<?php

namespace App\Http\Controllers;

use App\Models\ProcurementRequest;
use App\Models\BiddingProduct;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Winner;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomePage extends Controller
{
  public function index()
  {
      $requests = ProcurementRequest::where('status', 'approved')
          ->latest()
          ->get();

      $totalRequests = $requests->count();

      $limitedRequests = $requests->take(3);

      $biddingProducts = BiddingProduct::with('bids')->get();
      $totalBids = $biddingProducts->sum(function ($biddingProduct) {
          return $biddingProduct->bids->count();
      });

      $biddings = BiddingProduct::latest()->limit(3)->get();
      $totalBiddings = $biddings->count();

      foreach ($biddings as $bidding) {
          if (!$bidding->start_date instanceof Carbon\Carbon) {
              $bidding->start_date = Carbon::parse($bidding->start_date);
          }

          if (!$bidding->end_date instanceof Carbon\Carbon) {
              $bidding->end_date = Carbon::parse($bidding->end_date);
          }

          $bidding->progress = $this->calculate_progress($bidding->start_date, $bidding->end_date);
          $bidding->countdown = $this->calculate_countdown($bidding->end_date);
      }

      $winnersCount = Winner::count();

      $purchaseInvoices = Invoice::count();
      $budgetUse = Invoice::sum('amount_paid'); // Replace 'amount' with the actual column name for budget use
      $numberOfInvoices = Invoice::count();
      $currentBudget = 5000;

      $invoice = Invoice::with('payments')->first(); // Fetch a single invoice with its payments

      $biddingProducts = BiddingProduct::with('winners')->get();
      return view('app.home', compact('limitedRequests', 'biddings', 'totalBiddings', 'biddingProducts', 'winnersCount', 'totalBids', 'invoice', 'purchaseInvoices', 'budgetUse', 'numberOfInvoices', 'currentBudget', 'totalRequests','biddingProducts' ));
  }


private function calculate_progress($start_date, $end_date)
    {
        // Ensure $start_date and $end_date are Carbon instances
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);

        $totalDuration = $end_date->diffInSeconds($start_date);
        $elapsed = now()->diffInSeconds($start_date);

        if ($totalDuration === 0) {
            return 100;
        }

        $progressPercentage = min(100, ($elapsed / $totalDuration) * 100);
        return $progressPercentage;
    }
      private function calculate_countdown($end_date)
      {
          $end_date = Carbon::parse($end_date);
          $now = now();
          $timeRemaining = $end_date->diff($now)->format('%dd %hh %im %ss');
          return $timeRemaining;
      }

  public function create()
{
    $biddings = BiddingProduct::all(); // Fetch the biddings data from the database

    return view('app.procurement.biddings.create', compact('biddings'));
}
}
