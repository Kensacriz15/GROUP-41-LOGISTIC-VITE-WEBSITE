<?php

namespace App\Http\Controllers;

use App\Models\BiddingProduct;
use App\Models\Bid;
use App\Events\NewBidPlaced;
use Illuminate\Http\Request;
use App\Models\Invoice;
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
        // Check if an invoice already exists for the bid
        $existingInvoice = Invoice::where('bid_id', $bidId)->first();
        if ($existingInvoice) {
            // Return the existing invoice as a download
            $pdf = PDF::loadView('app.procurement.invoices.invoice-template', [
                'invoice' => $existingInvoice,
                'logoPath' => public_path('images/logo.png')
            ]);
            return $pdf->stream('invoice.pdf');
        }

        // 1. Fetch Bid Data with Relationships
        $biddingProduct = BiddingProduct::with('winners.supplier', 'winners.vendor')
            ->whereHas('winners', function ($query) use ($bidId) {
                $query->where('bid_id', $bidId);
            })
            ->firstOrFail();

        // Find Winning Bid
        $bid = $biddingProduct->winners->where('bid_id', $bidId)->first();

        // 2. Create Invoice
        $invoice = new Invoice();
        $invoice->invoice_number = $this->generateInvoiceNumber();

        // 3. Populate Invoice Items
        $invoice->items = [
            [
                'description' => $bid->biddingProduct->name,
                'qty' => 1,
                'price' => $bid->amount
            ]
        ];

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

        // Generate PDF
        $pdf = PDF::loadView('app.procurement.invoices.invoice-template', [
            'invoice' => $invoice,
            'logoPath' => public_path('images/logo.png')
        ]);

        // Return the PDF as a download
        return $pdf->stream('invoice.pdf');
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

    function calculateTotal($subtotal, $discount)
    {
        return $subtotal - $discount;
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
        ->value('value') ?? 5000;

        return view('app.procurement.invoices.index-invoices', compact('invoices', 'currentBudget'));
    }
public function editInvoice($bidId)
{
    $invoice = Invoice::with('bid')->findOrFail($bidId);
    return view('app.procurement.invoices.edit-invoice', compact('invoice'));
}
  }
