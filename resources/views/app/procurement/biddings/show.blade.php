@extends('layouts/layoutMaster')

@section('title', 'Biddings!')

@section('content')
@php
  $now = time();
  $start = strtotime($bidding->start_date);
  $end = strtotime($bidding->end_date);
  $totalDuration = max(1, $end - $start);
  $elapsedDuration = max(0, $now - $start);
  $progressPercentage = ($elapsedDuration / $totalDuration) * 100;
  $countdownSeconds = max(0, $end - $now);
  $countdownDays = floor($countdownSeconds / (60 * 60 * 24));
  $countdownHours = floor(($countdownSeconds % (60 * 60 * 24)) / (60 * 60));
  $countdownMinutes = floor(($countdownSeconds % (60 * 60)) / 60);
  $countdownSeconds %= 60;
@endphp

@if ($now > $end)
<div class="progress mb-4">
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: {{ $progressPercentage }}%" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
  <div class="countdown mb-4 text-center">
    <p class="mb-0"><strong>Ended by:</strong> {{ $bidding->end_date->format('F j, Y') }}</p>
</div>
@else
  <div class="progress mb-4">
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ $progressPercentage }}%" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
  </div>

  <div class="countdown mb-4 text-center">
    <p class="mb-0"><strong>Remaining Time:</strong> {{ $countdownDays }} days, {{ $countdownHours }} hours, {{ $countdownMinutes }} minutes, and {{ $countdownSeconds }} seconds</p>
  </div>
@endif

<div class="row justify-content-center">
  <div class="col-lg-8 col-md-12">
    <div class="card mb-4" style="height: 600px;">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title m-0">{{ $bidding->name }}</h3>
      </div>
      <div class="card-body">
        <div class="text-center mb-4">
          <div class="d-none d-md-block">
            @if ($bidding->image)
              <img src="{{ asset('images/' . $bidding->image) }}" alt="{{ $bidding->name }}" style="max-width: 500px; height: 450px;" class="img-fluid">
            @endif
          </div>
          <div class="d-md-none">
            @if ($bidding->image)
              <img src="{{ asset('images/' . $bidding->image) }}" alt="{{ $bidding->name }}" style="max-width: 100%; height: auto;" class="img-fluid">
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-12 col-lg-4">
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="card-title m-0">Bidding details</h6>
      </div>
      <div class="card-body">
        <dl class="row">
          <dt class="col-sm-4">Description:</dt>
          <dd class="col-sm-8">{{ $bidding->description }}</dd>

          <dt class="col-sm-4">Starting Price: </dt>
          <dd class="col-sm-8">₱ {{ $bidding->starting_price }}</dd>

          <dt class="col-sm-4">Start Date:</dt>
          <dd class="col-sm-8">{{ $bidding->start_date ? $bidding->start_date->format('M d, Y') : '' }}</dd>

          <dt class="col-sm-4">End Date:</dt>
          <dd class="col-sm-8">{{ $bidding->end_date ? $bidding->end_date->format('M d, Y') : '' }}</dd>

          <dt class="col-sm-4">External Request ID:</dt>
          <dd class="col-sm-8">{{ $bidding->external_request_id }}</dd>

          <dt class="col-sm-4">Status:</dt>
                      <dd class="col-sm-8">
                      @if($bidding->isOpen())
    <span class="badge badge-success">Open</span>
@else
    <span class="badge badge-secondary">Closed</span>
@endif
                      </dd>

        </dl>
      </div>
    </div>

    <div class="card mb-4">
  <div class="card-header d-flex justify-content-between">
    <h6 class="card-title m-0">Place Bid</h6>
  </div>
  <div class="card-body">
    @if ($bidding->bids()->count() && $bidding->lowestBid)
      <h3>Current Lowest Bid: ₱{{ $bidding->lowestBid->amount }}</h3>
    @endif

    @if ($now > $end)
      <p class="text-danger">Bidding has ended. You cannot place a bid.</p>
    @else
      <form method="POST" action="{{ route('app.procurement.biddings.bids.store', $bidding->id) }}">
        @csrf
        <div class="form-group">
          <label for="bid_type">Place Bid:</label>
          <select name="bid_type" id="bid_type" class="form-control" required>
            <option value="">-- Select --</option>
            <option value="supplier">Supplier</option>
            <option value="vendor">Vendor</option>
          </select>
        </div>

        <div class="form-group" id="supplier-select" style="display: none;">
          <label for="supplier_id">Select Supplier:</label>
          <select name="supplier_id" id="supplier_id" class="form-control">
            <option value="">-- Select --</option>
            @foreach ($suppliers as $supplier)
              <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group" id="vendor-select" style="display: none;">
          <label for="vendor_id">Select Vendor:</label>
          <select name="vendor_id" id="vendor_id" class="form-control">
            <option value="">-- Select --</option>
            @foreach ($vendors as $vendor)
              <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="amount">Your Bid Amount:</label>
          <input type="number" step="0.01" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" required>
          @error('amount')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Place Bid</button>
      </form>
    @endif

    @can('update', $bidding)
      <a href="{{ route('app.procurement.biddings.edit', $bidding->id) }}" class="btn btn-warning">Edit</a>
    @endcan

    <a href="/procurement/biddings" class="btn btn-link">Back to List</a>
  </div>
</div>
</div>
</div>

<script>
  document.getElementById('bid_type').addEventListener('change', function() {
    document.getElementById('supplier-select').style.display = (this.value === 'supplier') ? 'block' : 'none';
    document.getElementById('vendor-select').style.display = (this.value === 'vendor') ? 'block' : 'none';
  });

  $('form').submit(function(event) {
    if ($('#bid_type').val() === 'supplier' && !$('#supplier_id').val()) {
      alert('Please select a supplier.');
      event.preventDefault();
    } else if ($('#bid_type').val() === 'vendor' && !$('#vendor_id').val()) {
      alert('Please select a vendor.');
      event.preventDefault();
    }
  });
</script>
@endsection
