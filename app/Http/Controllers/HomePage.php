<?php

namespace App\Http\Controllers;

use App\Models\ProcurementRequest;
use App\Models\BiddingProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePage extends Controller
{
  public function index()
  {
      $requests = ProcurementRequest::where('status', 'approved')
                                    ->latest()
                                    ->limit(3)
                                    ->get();

                                    $biddings = BiddingProduct::latest()->limit(3)->get(); // Limit to 3 recent biddings
                                    return view('app.home', compact('requests', 'biddings')); // Pass 'biddings'
  }

  public function create()
{
    $biddings = BiddingProduct::all(); // Fetch the biddings data from the database

    return view('app.procurement.biddings.create', compact('biddings'));
}
}
