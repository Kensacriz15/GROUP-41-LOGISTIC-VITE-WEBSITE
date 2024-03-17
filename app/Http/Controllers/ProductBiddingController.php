<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class ProductBiddingController extends Controller
{
public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'starting_price' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'start_date' => 'required|date|before_or_equal:end_date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $validatedData['image'] = $imageName;
    }

    lms_g41_bidding_product::create($validatedData);

    return redirect()->back()->with('success', 'Product bidding created!');
}
}
