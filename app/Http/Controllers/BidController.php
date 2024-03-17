<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class BidController extends Controller

{
public function handleBid(Request $request)
{
    // Validate the bid data from $request
    $validatedData = $request->validate([
        'product_id' => 'required|integer',
        'bid_amount' => 'required|numeric',
        // ... other validation rules
    ]);

    // Create your bid (assuming you have a Bid model)
    $bid = Bid::create($validatedData);

    // Trigger the event with bid data
    event(new NewBidPlaced($bid));
}
}
