@extends('layouts/layoutMaster')

@section('title', 'Unified Procurement Management')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss',
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss'
])
@endsection

@section('page-style')
<!-- Page -->
@vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/swiper/swiper.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  ])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/dashboards-analytics.js'
])
@endsection

@section('content')

<div class="row">
  <!-- Website Analytics -->
  <div class="col-lg-6 mb-4">
    <div class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg" id="swiper-with-pagination-cards">
      <div class="swiper-wrapper">
        <div class="swiper-slide" >
          <div class="row">
            <div class="col-12">
              <h5 class="text-white mb-0 mt-2">Procurement</h5>
              <small>Total {{ $winnersCount ?? '0' }} Vendor and Supplier Acquire</small>
            </div>
            <div class="row">
              <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                <h6 class="text-white mt-0 mt-md-3 mb-3">Attainment</h6>
                <div class="row">
                  <div class="col-6">
                    <ul class="list-unstyled mb-0">
                      <li class="d-flex mb-4 align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">{{ count($requests) }}</p>
                        <p class="mb-0">Total Requests</p>
                      </li>
                      <li class="d-flex align-items-center mb-2">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">{{ $totalbiddings ?? '0' }}</p>
                        <p class="mb-0">Product Biddings</p>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <ul class="list-unstyled mb-0">
                      <li class="d-flex mb-4 align-items-center">
                      <p class="mb-0 fw-medium me-2 website-analytics-text-bg">{{ $totalBids }}</p>
                      <p class="mb-0">Bids</p>
                      </li>
                      <li class="d-flex align-items-center mb-2">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">{{ $winnersCount ?? '0' }}</p>
                        <p class="mb-0">Winners</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
              <i class="fa-solid fa-handshake" style="font-size: 170px;" alt="Website Analytics" width="170" class="card-website-analytics-img"></i>              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
  <div class="row">
    <div class="col-12">
      <h5 class="text-white mb-0 mt-2">Purchase</h5>
      <small>Total {{ $currentBudget }} Budget </small>
    </div>
    <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
      <h6 class="text-white mt-0 mt-md-3 mb-3">Spending</h6>
      <div class="row">
        <div class="col-6">
          <ul class="list-unstyled mb-0">
            <li class="d-flex mb-4 align-items-center">
              <p class="mb-0 fw-medium me-2 website-analytics-text-bg">{{  $budgetUse }}</p>
              <p class="mb-0">Spend</p>
            </li>
            <li class="d-flex align-items-center mb-2">
              <p class="mb-0 fw-medium me-2 website-analytics-text-bg">{{ $numberOfInvoices }}</p>
              <p class="mb-0">Invoices</p>
            </li>
          </ul>
        </div>
        <div class="col-6">
          <ul class="list-unstyled mb-0">
            <li class="d-flex mb-4 align-items-center">
              <p class="mb-0 fw-medium me-2 website-analytics-text-bg">{{ $currentBudget - ($invoice->amount_paid ?? 0) }}</p>
              <p class="mb-0">Invoice Balance</p>
            </li>
            <li class="d-flex align-items-center mb-2">
              <p class="mb-0 fw-medium me-2 website-analytics-text-bg">//</p>
              <p class="mb-0">Completed Transactions</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
      <i class="fa-solid fa-peso-sign" style="font-size: 170px;" alt="Website Analytics" width="170" class="card-website-analytics-img"></i>
    </div>
  </div>
</div>
        <div class="swiper-slide" >
          <div class="row">
            <div class="col-12">
              <h5 class="text-white mb-0 mt-2">Inventory</h5>
              <small>Total 28.5% Conversion Rate</small>
            </div>
            <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
              <h6 class="text-white mt-0 mt-md-3 mb-3">Revenue Sources</h6>
              <div class="row">
                <div class="col-6">
                  <ul class="list-unstyled mb-0">
                    <li class="d-flex mb-4 align-items-center">
                      <p class="mb-0 fw-medium me-2 website-analytics-text-bg">268</p>
                      <p class="mb-0">Direct</p>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                      <p class="mb-0 fw-medium me-2 website-analytics-text-bg">62</p>
                      <p class="mb-0">Referral</p>
                    </li>
                  </ul>
                </div>
                <div class="col-6">
                  <ul class="list-unstyled mb-0">
                    <li class="d-flex mb-4 align-items-center">
                      <p class="mb-0 fw-medium me-2 website-analytics-text-bg">890</p>
                      <p class="mb-0">Organic</p>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                      <p class="mb-0 fw-medium me-2 website-analytics-text-bg">1.2k</p>
                      <p class="mb-0">Campaign</p>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
            <i class="fa-solid fa-warehouse" style="font-size: 170px;" alt="Website Analytics" width="170" class="card-website-analytics-img"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
  <!--/ Website Analytics -->

  <!-- Bidding Overview -->
  @php
$currentDate = now();
$activeBiddings = 0;
@endphp


  @foreach($biddings as $bidding)
    @if($bidding->end_date > $currentDate)
      <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <small class="d-block mb-1 text-muted">Current Bidding</small>
              <p class="card-text text-success">Bids: {{ $bidding->bids->count() }}</p>
            </div>
            <h4 class="card-title mb-1">{{$bidding->name }}</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-4">
                <div class="d-flex gap-2 align-items-center mb-2">
                  <span class="badge bg-success p-1 rounded"><i class="fas fa-money-bill ti-xs"></i></span>
                  <p class="mb-0">Lowest Bid: </p>
                </div>
                @if ($bidding->bids()->count() && $bidding->lowestBid)
                  <h5 class="mb-0 pt-1 text-nowrap">₱ {{$bidding->lowestBid->amount}}</h5>
                @else
                  <h5 class="mb-0 pt-1 text-nowrap">No Bids</h5>
                @endif
                <small class="text-muted"></small>
              </div>
              <div class="col-4">
                <div class="divider divider-vertical"></div>
              </div>
              <div class="col-4 text-end">
                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                  <p class="mb-0">Info</p>
                  <span class="badge bg-label-primary p-1 rounded">
                    <a href="{{ route('app.procurement.biddings.show', $bidding->id) }}">
                      <i class="ti ti-link ti-xs"></i>
                    </a>
                  </span>
                </div>
                <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                  <img src="{{ asset('images/' . $bidding->image) }}" alt="Bidding Product Image" style="width: 50px; height: 45px; border: 2px solid lightblue;">
                </h5>
              </div>
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
      </div>
      @php
        $activeBiddings++;
      @endphp
    @endif
  @endforeach

  @if($activeBiddings == 0)
  <div class="col-lg-6 col-md-12 mb-4">
    <div class="card h-100">
      <div class="card-body text-center d-flex align-items-center justify-content-center">
        <div class="card-header">
          <h6 class="mb-0">No Bidding Now</h6>
        </div>
      </div>
    </div>
  </div>
@endif

  <!--/ Sales Overview -->

  <div class="row">
  <!-- Bidding -->
  <div class="col-lg-3 col-sm-6 mb-4 text-center">
  <div class="card h-100">
    <div class="card-body">
      <div class="badge p-2 bg-label-success mb-2 rounded"><i class="fa-solid fa-file-contract ti-md"></i></div>
      <h5 class="card-title mb-1 pt-2">Bidding</h5>
      <div class="row d-flex flex-column">
        <a href="/procurement/biddings" class="btn rounded-pill btn-sm btn-info mb-2">List</a>
        <a href="/procurement/biddings/create" class="btn rounded-pill btn-sm btn-warning mb-2">Create</a>
        <a href="/procurement-indexbids" class="btn rounded-pill btn-sm btn-success mb-2">Winners / Invoices</a>
        </div>
    </div>
  </div>
</div>

  <!-- Invoices -->
  <div class="col-lg-3 col-sm-6 mb-4 text-center">
  <div class="card h-100">
    <div class="card-body">
        <div class="badge p-2 bg-label-info mb-2 rounded"><i class="fa-solid fa-file-invoice ti-md"></i></div>
        <h5 class="card-title mb-1 pt-2">Invoices</h5>
        <div class="row d-flex flex-column">
        <a href="/invoices" class="btn rounded-pill btn-sm btn-info mb-2">List</a>
        <a href="/procurement-indexbids" class="btn rounded-pill btn-sm btn-warning mb-2">Create</a>
        <a href="/test-winners" class="btn rounded-pill btn-sm btn-danger mb-2" onclick="return confirm('Are you sure you want to trigger this action make sure you have ended bidding?') ? true : false;">Trigger Winners</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Inventory -->
  <div class="col-lg-3 col-sm-6 mb-4 text-center">
  <div class="card h-100">
      <div class="card-body">
        <div class="badge p-2 bg-label-primary mb-2 rounded"><i class="fa-solid fa-store ti-md"></i></div>
        <h5 class="card-title mb-1 pt-2">Inventory</h5>
        <div class="row d-flex flex-column">
        <a href="/procurement/biddings" class="btn rounded-pill btn-sm btn-info mb-2">List</a>
        <a href="/procurement/biddings/create" class="btn rounded-pill btn-sm btn-warning mb-2">Create</a>
        <a href="/procurement/biddings" class="btn rounded-pill btn-sm btn-primary mb-2">Info</a>
        </div>
      </div>
    </div>
  </div>


  <div class="col-xl-3 col-md-6 mb-4">
  <div class="card h-100">
    <div class="card-header d-flex justify-content-between">
      <div class="card-title mb-0">
        <div class="badge p-2 bg-label-warning mb-2 rounded"><i class="fas fa-clock-rotate-left"></i></div>
        <h5 class="card-title mb-1 pt-2">Payment History</h5>
      </div>
    </div>
    <div class="card-body">
      <div class="payment-history" style="margin-top: 10px;">
        @if($invoice && $invoice->payments->isNotEmpty())
          @foreach($invoice->payments as $payment)
            <div class="payment-item" style="margin-bottom: 10px; display: flex;">
              <div class="payment-date" style="margin-right: 10px;">{{ $payment->created_at->format('F d, Y') }}</div>
              <div class="payment-amount"> ₱ {{ $payment->amount }}</div>
              <hr class="payment-line" style="margin-top: 10px; margin-bottom: 10px; border: none; border-top: 1px solid #ddd;">
            </div>
          @endforeach
        @else
          <div class="no-payment-history">No payment history available.</div>
        @endif
      </div>
    </div>
  </div>
</div>











<div class="container">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
            <h4 style="text-align: center;">Recent Procurement Requests</h4>
                @foreach($requests as $request)
                <div class="col-sm-4 mb-4">
                    <div class="card bg-light border-success">
                        <div class="card-body">
                            <h5 class="card-title">Request ID: {{ $request->external_request_id }}</h5>
                            <p class="card-text">Status: {{ $request->status }}</p>
                            <p class="card-text">Department: {{ $request->department->name }}</p>
                            <a href="{{ route('app.procurement.listrequestshow', $request->id) }}" class="btn btn-sm btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <a href="{{ route('app.procurement.listrequest', $request) }}" class="btn btn-sm btn-warning">Show More</a>
    </div>
</div>

 <!-- Biddings Section -->

<div class="container">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
            <h4 style="text-align: center;">Recent Biddings</h4>
            @foreach($biddings as $bidding)
                <div class="col-sm-4 mb-4">
                    <div class="card bg-light border-success">
                        <div class="card-body">
                        <h5 class="card-title">Bidding Name: {{ $bidding->name }}</h5>
                        <p
                            @if($bidding->isOpen())
    <span class="badge badge-success">Open</span>
@else
    <span class="badge badge-secondary">Closed</span>
@endif
                        </p>
                            <p class="card-text">Starting Price: {{ $bidding->starting_price }}</p>
                            <a href="{{ route('app.procurement.biddings.show', $bidding->id) }}" class="btn btn-sm btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
                <a href="{{ route('app.procurement.biddings.create')}}" class="btn btn-sm btn-primary">Create</a>
            </div>
        </div>
        <a href="{{ route('app.procurement.biddings.index') }}" class="btn btn-sm btn-warning">Show More</a>
    </div>
  </div>
</div>


@endsection
