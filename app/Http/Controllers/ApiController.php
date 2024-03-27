<?php

namespace App\Http\Controllers;
use App\Models\ProcurementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
  public function Procurement()
  {
      try {
          // Fetch transactions from the external API
          $procurement = ProcurementRequest::all();

          // Return the transactions as JSON response
          return response()->json($procurement);
      } catch (\Exception $e) {
          // Log the error
          Log::error('Error fetching transactions from external API: ' . $e->getMessage());

          // Return    an error response
          return response()->json(['error' => 'Failed to fetch transactions'], 500);
      }
  }
}
