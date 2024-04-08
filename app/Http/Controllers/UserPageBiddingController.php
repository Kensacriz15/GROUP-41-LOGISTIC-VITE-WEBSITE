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

class UserPageBiddingController extends Controller

{
  public function index(Request $request)
  {
      $search = $request->input('search');

      $biddingsQuery = BiddingProduct::query();

      if ($search) {
          $biddingsQuery->where('name', 'like', '%' . $search . '%');
      }

      $biddings = $biddingsQuery->latest()->limit(3)->get();
      $biddingProducts = BiddingProduct::with('bids')->get();
      $totalBiddings = $biddings->count();
      $totalBids = $biddingProducts->sum(function ($biddingProduct) {
          return $biddingProduct->bids->count();
      });

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

      return view('app.procurement.biddings.userpagebidding', compact('biddings', 'totalBiddings', 'biddingProducts', 'totalBids', 'search'));
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
}
