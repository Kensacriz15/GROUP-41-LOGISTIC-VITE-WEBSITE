<?php

namespace App\Http\Controllers;

use App\Models\ProcurementRequest;
use Illuminate\Http\Request;

class HomePage extends Controller
{
  public function index()
  {
      $requests = ProcurementRequest::where('status', 'approved')
                                    ->latest()
                                    ->limit(3)
                                    ->get();

      return view('app.home', compact('requests'));
  }
}
