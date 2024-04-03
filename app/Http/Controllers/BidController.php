<?php

namespace App\Http\Controllers;

use App\Models\BiddingProduct;
use App\Models\Bid;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Winner;
use App\Events\NewBidPlaced;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
//use Illuminate\Support\Facades\Auth; // Assuming you're using authentication

class BidController extends Controller
{
    public function handleBid(Request $request)
    {
        // Validate the bid data from $request
        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:lms_g41_bidding_products,id', // Validate product exists
            'bid_amount' => 'required|numeric',
        ]);

        // Check bidding product is open
        $product = BiddingProduct::findOrFail($validatedData['product_id']);
        if (!$product->isOpen()) {
            return response()->json(['error' => 'Bidding is closed for this product.'], 400); // Or a redirect
        }

        // Assuming you want to associate the bid with the logged-in user
        //$validatedData['user_id'] = Auth::id();

        // Create your bid (assuming you have a Bid model)
        $bid = $product->bids()->create($validatedData);

        // Trigger the event with bid data
        event(new NewBidPlaced($bid));

        return response()->json(['message' => 'Bid placed successfully!']);
    }

    public function index()
    {
        $biddingProducts = BiddingProduct::with('bids')->paginate(10);

        return view('app.procurement.indexbids', compact('biddingProducts')); // Consider a dedicated view path
    }
    public function show($productId)
    {
        $biddingProduct = BiddingProduct::with('bids')->findOrFail($productId);

        return view('app.procurement.listbids', compact('biddingProduct'));
    }

    public function determineWinners()
    {
        $this->where('end_date', '<=', now())->each(function ($product) {
            if ($product->winners()->count() > 0) {
                return; // Skip to the next product if winners already exist
            }

            // Find the winning bid(s) for the CURRENT bidding product
            $winningBidQuery = $product->bids()->orderBy('amount'); // Scoped to the product's bids

            // Handle potential ties (optional - adjust if needed)
            $winningBids = $winningBidQuery->get(); // Get all bids with the lowest amount

            foreach ($winningBids as $winningBid) {
                try {
                    Winner::create([
                        'bidding_product_id' => $product->id,
                        'bid_id' => $winningBid->id,
                    ]);
                } catch (\Exception $e) {
                    // Handle the exception appropriately:
                    Log::error('Winner creation failed:', ['product_id' => $product->id, 'exception' => $e]);
                }
            }
        });
    }


    public function viewInvoice($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $pdf = PDF::loadView('app.procurement.invoices.invoice-template', ['invoice' => $invoice]);
        $invoice->logo_path = asset('assets/img/favicon/bbox-express-logo1.png');
        return $pdf->stream('invoice.pdf');
    }

    public function createInvoice($bidId)
{
    // Check if a winner exists for the given bid ID
    $winner = Winner::where('bid_id', $bidId)->firstOrFail();

    // ADJUSTMENT: Handle bids that are automatically winners (i.e., sole bids)
    if (!$winner) {
        // Retrieve product directly if no winner exists
        $biddingProduct = Bid::findOrFail($bidId)->biddingProduct;
    } else {
        // Get product through the 'bid' relationship if a winner exists
        $bid = $winner->bid;
        $biddingProduct = $bid->biddingProduct;
    }

    // Retrieve the necessary data for creating the invoice
    $bid = $winner->bid;
    $biddingProduct = $bid->biddingProduct;

    // Check if an invoice already exists for the bid
    $existingInvoice = Invoice::where('bid_id', $bid->id)->first();
    if ($existingInvoice) {
        // Return the existing invoice as a download
        $pdf = PDF::loadView('app.procurement.invoices.invoice-template', [
            'invoice' => $existingInvoice,
            'logoPath' => public_path('images/logo.png')
        ]);
        return $pdf->stream('invoice.pdf');
    }

    // Create the invoice
    $invoice = new Invoice();
    $invoice->invoice_number = $this->generateInvoiceNumber();

    // Populate invoice items
    $invoiceItems = [];

    $biddingProduct = $bid->biddingProduct;
    $invoiceItems[] = [
        'description' => $biddingProduct->name,
        'qty' => 1,
        'price' => $bid->amount
    ];

    $invoice->items = $invoiceItems;

    // Calculate subtotal, tax, and total
    $invoice->subtotal = $this->calculateSubtotal($invoice->items);
    $invoice->tax = $this->calculateTax($invoice->subtotal);
    $invoice->total = $invoice->subtotal + $invoice->tax;

    // Set invoice dates
    $invoice->invoice_date = now();
    $invoice->due_date = now()->addDays(30);

    // Set invoice contact
    if ($bid->supplier) {
        $invoice->invoice_to_name = $bid->supplier->supplier_name;
    } else if ($bid->vendor) {
        $invoice->invoice_to_name = $bid->vendor->vendor_name;
    } else {
        $invoice->invoice_to_name = 'Unknown';
    }

    // Link Invoice to Bid
    $invoice->bid_id = $bid->id;

    // Save the Invoice
    $invoice->amount_paid = 0;
    $invoice->balance = $invoice->total;
    $invoice->save();

    // Update currentBudget
    $currentBudget = DB::table('settings')
        ->where('name', 'current_budget')
        ->value('value');

    $newBudget = $currentBudget - ($invoice->total - $invoice->amount_paid); // Adjust the calculation

    DB::table('settings')
        ->where('name', 'current_budget')
        ->update(['value' => $newBudget]);

    // Generate PDF
    $pdf = PDF::loadView('app.procurement.invoices.invoice-template', [
        'invoice' => $invoice,
        'logoPath' => public_path('images/logo.png')
    ]);

    // Return the PDF as a download
    return $pdf->stream('invoice.pdf');
}


    public function deletePayment($invoiceId)
{
    // Retrieve the invoice
    $invoice = Invoice::findOrFail($invoiceId);

    // Update currentBudget
    $currentBudget = DB::table('settings')
        ->where('name', 'current_budget')
        ->value('value');

    $newBudget = $currentBudget + $invoice->amount_paid; // Add the payment amount back to the budget

    DB::table('settings')
        ->where('name', 'current_budget')
        ->update(['value' => $newBudget]);

    // Update the invoice amount_paid and balance
    $invoice->amount_paid = 0;
    $invoice->balance = $invoice->total;
    $invoice->save();

    // Return a response or redirect as needed
}

    function generateInvoiceNumber()
    {
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();

        // 1. Extract the numerical part
        $lastInvoiceNumber = 0;
        if ($lastInvoice) {
            $lastInvoiceNumber = (int) preg_replace('/[^0-9]/', '', $lastInvoice->invoice_number); // Remove non-numeric characters
        }

        // 2. Perform calculation
        $newInvoiceNumber = $lastInvoiceNumber + 1;

        // 3. Reformat with padding
        return 'INV-' . str_pad($newInvoiceNumber, 5, '0', STR_PAD_LEFT);
    }

    function populateItems($bid)
    {
        return [
            'product_1' => [ // Replace 'product_1' with a meaningful identifier
                'description' => $bid->biddingProduct->name, // Assuming a relationship exists
                'qty' => 1,
                'price' => $bid->amount
            ]
        ];
    }

    function calculateTax($subtotal, $taxPercentage = 10) // Assuming 10% tax
    {
        return ($subtotal * $taxPercentage) / 100;
    }

    function calculateDiscount($subtotal)
    {
        // Assuming a fixed discount percentage of 10%
        $discountPercentage = 10;
        $discount = ($subtotal * $discountPercentage) / 100;
        return $discount;
    }

    function calculateTotal($subtotal, $discount, $tax)
    {
      return $subtotal - $discount + $tax;
    }
    public function calculateSubtotal($items)
{
    $subtotal = 0;
    foreach ($items as $item) {
        $subtotal += $item['qty'] * $item['price'];
    }
    return $subtotal;
}

public function updateInvoice(Request $request, $invoiceId)
{
    $invoice = Invoice::findOrFail($invoiceId);

    // Update invoice items
    $items = $request->input('items');
    $updatedItems = [];

    foreach ($items as $index => $item) {
        $updatedItems[] = [
            'description' => $item['description'],
            'qty' => $item['qty'],
            'price' => $item['price'],
        ];
    }
    // Update amount paid
    $invoice->amount_paid = $request->input('amount_paid');

    $invoice->items = $updatedItems;

    // Recalculate subtotal, tax, and total
    $invoice->subtotal = $this->calculateSubtotal($invoice->items);
    $invoice->tax = $this->calculateTax($invoice->subtotal);
    $invoice->total = $invoice->subtotal + $invoice->tax;

    // Save the updated invoice
    $invoice->save();

    return redirect()->back()->with('success', 'Invoice updated successfully');
}

public function indexInvoices()
{
    $invoices = Invoice::with('bid')->paginate(10);

    // Fetch the budget
    $currentBudget = DB::table('settings')
        ->where('name', 'current_budget')
        ->value('value');

    // Calculate the invoice balance and update the status
    foreach ($invoices as $invoice) {
        $invoice->balance = $invoice->total - $invoice->amount_paid;
        $invoice->status = $invoice->balance > 0 ? 'Unpaid' : 'Paid';
    }

    // Update the current budget by deducting the total balance of unpaid invoices
    $unpaidInvoicesBalance = $invoices->sum(function ($invoice) {
        return $invoice->balance > 0 ? $invoice->balance : 0;
    });

    $currentBudget -= $unpaidInvoicesBalance;

    return view('app.procurement.invoices.index-invoices', compact('invoices', 'currentBudget'));
}

public function editInvoice($bidId)
{
    $invoice = Invoice::with('bid')->findOrFail($bidId);
    return view('app.procurement.invoices.edit-invoice', compact('invoice'));
}
public function processPayment(Request $request, Invoice $invoice)
{
    $validatedData = $request->validate([
        'amount_paid' => 'required|numeric|min:0.01',
    ]);

    $newPaymentAmount = $validatedData['amount_paid'];

    // Get the old payment amount
    $oldPaymentAmount = $invoice->amount_paid;

    // *** Original Payment Logic (no changes needed) ***
    $invoice->amount_paid += $newPaymentAmount;
    $invoice->save();

    // *** Update currentBudget ***
    $currentBudget = DB::table('settings')
        ->where('name', 'current_budget')
        ->value('value');

    $newBudget = $currentBudget - ($newPaymentAmount - $oldPaymentAmount);
    $newBudget = max($newBudget, 5000); // Ensure the budget is not less than 5000

    DB::table('settings')
        ->where('name', 'current_budget')
        ->update(['value' => $newBudget]);

    Payment::create([
        'invoice_id' => $invoice->id,
        'amount' => $newPaymentAmount,
    ]);

    return redirect()->route('app.procurement.invoices.index')
        ->with('success', 'Payment recorded for Invoice #' . $invoice->invoice_number);
}

  }
