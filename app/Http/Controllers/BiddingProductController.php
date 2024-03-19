<?php

namespace App\Http\Controllers;

use App\Models\ProcurementRequest;
use App\Models\Bid;
use App\Models\BiddingProduct;
use App\Models\Supplier;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class BiddingProductController extends Controller
{
  public function index()
{
    // Authorization check (if desired)
    //$this->authorize('viewAny', BiddingProduct::class);
    $biddings = BiddingProduct::query()->get();

    // Add filtering/ordering if needed
     // e.g., $biddings = $biddings->where('open_for_bids', true)->orderBy('start_date', 'desc')->paginate(10);

    return view('app.procurement.biddings.index', compact('biddings'));
}

  public function create()
    {
        $procurementRequests = ProcurementRequest::select('id', 'external_request_id')
                                                          ->where('status', 'approved') // Filter if needed
                                                          ->get();

        return view('app.procurement.biddings.create', compact('procurementRequests'));
    }

    public function store(Request $request)
    {
        // Standalone validation (alternative to form requests)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starting_price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Image handling
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = null; // Handle cases without an image
        }

        // Create product bidding
        BiddingProduct::create([
            'name' => $request->name,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'image' => $imageName,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'external_request_id' => $request->input('external_request_id')
        ]);

        return redirect()->back()->with('success', 'Product bidding created!');
    }
    // ... other imports ...


// ... inside your controller ...

public function edit(BiddingProduct $bidding)
{
    // Authorization check (if necessary)
    $this->authorize('update', $bidding);

    return view('app.procurement.biddings.edit', compact('bidding'));
}

public function destroy(BiddingProduct $bidding)
{
    // Authorization check (if necessary)
    $this->authorize('delete', $bidding);

    $bidding->delete();

    return redirect()->route('app.procurement.biddings.index')->with('success', 'Bidding deleted.');
}
public function show($id)
{
    // Authorization check (if necessary)
    // $this->authorize('view', $bidding);
    $bidding = BiddingProduct::findOrFail($id);
    $request = ProcurementRequest::with('department', 'user')->where('external_request_id', $id)->first();

    // Fetch existing bid (if any)
    $existingBid = null; // Initialize here
    $existingBid = $bidding->bids()->first();

    // Adjust data for view
    if ($existingBid) {
        if ($existingBid->supplier_id) {
            $vendors = Vendor::all();
        } else { // $existingBid->vendor_id exists
          $suppliers = Supplier::all();
          $vendors = Vendor::all();
        }
    } else {  // No existing bid
        $suppliers = Supplier::all();
        $vendors = Vendor::all();
    }

    return view('app.procurement.biddings.show', compact('bidding', 'request', 'suppliers', 'vendors', 'existingBid'));
}

public function storeBid(Request $request, BiddingProduct $bidding)
{
    // Authorization - Example using a Gate
    //Gate::authorize('bid-on-product', $bidding);
    // Validation

    $request->validate([
      'amount' => [
        'required',
        'numeric',
        'min:0.01',
        function ($attribute, $value, $fail) use ($bidding) {
            $threshold = $bidding->lowestBid ? $bidding->lowestBid->amount : $bidding->starting_price; // Determine the correct threshold

            if ($value >= $threshold) {
                $fail('Your bid must be lower than the current lowest bid or starting price.'); // You might customize the message
            }
        },
    ]
  ]);

    // Create the bid
    $bid = $bidding->bids()->create([
      'bidding_product_id' => $bidding->id,
      'amount' => $request->input('amount'),

      // Dynamic Supplier/Vendor association
      'supplier_id' => $request->input('bid_type') === 'supplier' ? $request->input('supplier_id') : null,
      'vendor_id'  => $request->input('bid_type') === 'vendor' ? $request->input('vendor_id') : null,
  ]);

  BidPlaced::dispatch($bid);

    return redirect()->back()->with('success', 'Bid placed!');
}


}
