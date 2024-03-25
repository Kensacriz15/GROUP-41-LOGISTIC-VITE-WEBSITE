<?php

namespace App\Http\Controllers;

use App\Models\BiddingProduct;
use App\Models\Bid;
use App\Events\NewBidPlaced;
use Illuminate\Http\Request;
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
}
