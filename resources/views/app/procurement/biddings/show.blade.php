@extends('layouts/layoutMaster')

@section('title', 'Biddings!')

@section('content')
    <div class="container">
        <h1>{{ $bidding->name }}</h1>

        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-4">Description:</dt>
                    <dd class="col-sm-8">{{ $bidding->description }}</dd>

                    <dt class="col-sm-4">Starting Price:</dt>
                    <dd class="col-sm-8">{{ $bidding->starting_price }}</dd>

                    <dt class="col-sm-4">Start Date:</dt>
                    <dd class="col-sm-8">{{ $bidding->start_date->format('M d, Y') }}</dd>

                    <dt class="col-sm-4">End Date:</dt>
                    <dd class="col-sm-8">{{ $bidding->end_date->format('M d, Y') }}</dd>

                    <dt class="col-sm-4">External Request ID:</dt>
                    <dd class="col-sm-8">{{ $bidding->external_request_id }}</dd>


                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">
                        @if($bidding->open_for_bids)
                            <span class="badge badge-success">Open</span>
                        @else
                            <span class="badge badge-secondary">Closed</span>
                        @endif
                    </dd>
                </dl>

                @if ($bidding->bids()->count() && $bidding->lowestBid)
     <h3>Current Lowest Bid: {{ $bidding->lowestBid->amount }} </h3>
@endif
                <div class="form-group">
                <form method="POST" action="{{ route('app.procurement.biddings.bids.store', $bidding->id) }}">
    @csrf
    <label for="bid_type">Bid From:</label>
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
    <select name="vendor_id"  id="vendor_id" class="form-control">
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

                @can('update', $bidding)
                    <a href="{{ route('app.procurement.biddings.edit', $bidding->id) }}" class="btn btn-warning">Edit</a>
                @endcan
                <a href="/procurement/biddings" class="btn btn-link">Back to List</a>
            </div>

            {{-- Image Display (if applicable)  --}}
            @if ($bidding->image)
                <div class="col-md-6">
                    <img src="{{ asset('images/' . $bidding->image) }}" alt="{{ $bidding->name }}" class="img-fluid">
                </div>
            @endif
        </div>
    </div>

    <script>
document.getElementById('bid_type').addEventListener('change', function() {
  document.getElementById('supplier-select').style.display = (this.value === 'supplier') ? 'block' : 'none';
  document.getElementById('vendor-select').style.display = (this.value === 'vendor') ? 'block' : 'none';
});
</script>
@endsection
