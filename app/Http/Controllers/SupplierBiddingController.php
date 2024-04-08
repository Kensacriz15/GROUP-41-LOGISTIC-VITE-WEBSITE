<?php

namespace App\Http\Controllers;

use App\Models\BiddingProduct;
use App\Models\SupplierBid;
use App\Http\Requests\StoreSupplierBidRequest;
use Illuminate\Support\Facades\Auth;

class SupplierBiddingController extends Controller
{
    public function index()
    {
        // Fetch the open bidding products for suppliers
        $openBiddingProducts = BiddingProduct::where('open_for_bids', true)
            ->where('bidding_type', 'supplier')
            ->get();

        return view('supplier_bidding.index', compact('openBiddingProducts'));
    }

    public function create()
    {
        // Fetch the open bidding products for suppliers
        $openBiddingProducts = BiddingProduct::where('open_for_bids', true)
            ->where('bidding_type', 'supplier')
            ->get();

        return view('supplier_bidding.create', compact('openBiddingProducts'));
    }

    public function store(StoreSupplierBidRequest $request)
    {
        $validatedData = $request->validated();

        // Get the authenticated supplier's ID
        $supplierId = Auth::id();

        // Create the supplier bid
        SupplierBid::create([
            'supplier_id' => $supplierId,
            'bidding_product_id' => $validatedData['bidding_product_id'],
            'quantity' => $validatedData['quantity'],
            'proposed_price' => $validatedData['proposed_price'],
            'product_description' => $validatedData['product_description'],
            'status' => 'submitted', // Set the initial status of the bid
        ]);

        return redirect()->route('supplier_bidding.index')->with('success', 'Bid submitted successfully');
    }

    // Add other actions as needed: show, edit, update, destroy
}
