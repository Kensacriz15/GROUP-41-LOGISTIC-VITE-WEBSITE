<?php

namespace App\Http\Controllers;

class BiddingController extends Controller

{
public function index()
  {
    $biddingProducts = DB::table('lms_g41_bidding_products')
                             ->where('open_for_bids', true)
                             ->get();

    return view('app.procurement.biddings.biddingsproducts', compact('biddingProducts'));
  }


}
