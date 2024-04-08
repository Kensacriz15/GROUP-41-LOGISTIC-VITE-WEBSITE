@extends('layouts/layoutMaster')

@section('title', 'Browse Biddings!')

@section('content')
@php
$currentDate = now();
$activeBiddings = 0;
@endphp

<div class="container">
   <div class="row my-4">
      <div class="col text-center">
         <h3 class="fw-bold">Explore Biddings</h3>
         <p class="lead fs-6">Find the latest procurement biddings</p>
      </div>
   </div>
   <div class="row my-4 justify-content-center">
      <div class="col-lg-6">
         <div class="input-group">
            <input class="form-control rounded-end" type="text" placeholder="Search for Biddings...">
            <button class="btn btn-primary rounded-start" type="button">Search</button>
         </div>
      </div>
   </div>


   @foreach($biddings as $bidding)
      @if($bidding->end_date > $currentDate)
         <div class="col mb-3 col-sm-6 col-md-4">
            <div class="card h-100 w-60 border rounded">
               <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                  <img src="{{ asset('images/' . $bidding->image) }}" alt="Bidding Product Image" style="width: 100%; height: 200px; border: 2px solid lightblue;">
               </h5>
               <div class="card-body">
                  <h6 class="card-title" style="font-size: 14px; line-height: 1.2;">{{$bidding->name }}</h6>
                  <p class="card-text" style="font-size: 12px;">Current Bids: <span class="text-success">{{ $bidding->bids->count() }}</span></p>
                  @if ($bidding->bids()->count() && $bidding->lowestBid)
                     <p class="card-text" style="font-size: 12px;">Lowest Bid: ₱ {{$bidding->lowestBid->amount}}</p>
                  @else
                     <p class="card-text" style="font-size: 12px;">No Bids Yet</p>
                  @endif
                  <a href="{{ route('app.procurement.biddings.show', $bidding->id) }}" class="btn btn-primary btn-sm mt-3" style="font-size: 12px;">View Details</a>
               </div>
               <div class="d-flex align-items-center mt-4">
                  <div class="progress w-100" style="height: 8px;">
                     <div class="progress-bar" style="width: {{ $bidding->progress }}%"></div>
                  </div>
               </div>
               <div class="mt-2">
                  @if ($bidding->progress < 100)
                     <div class="text-center" id="countdown">
                        {{ $bidding->countdown }}
                     </div>
                  @else
                     <div class="text-center">End Date: {{ $bidding->end_date->format('F j, Y') }}</div>
                  @endif
               </div>
            </div>
         </div>
         @php
            $activeBiddings++;
         @endphp
      @endif
   @endforeach
</div>

@if($activeBiddings == 0)
   <div class="text-center my-5">
      <h4>No active biddings at the moment. Please check back later!</h4>
   </div>
@endif

@endsection
