@extends('layouts/layoutMaster')

@section('title', 'Unified Procurement Management')

@section('content')
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
                            <p class="card-text">Status: {{ $bidding->open_for_bids ? 'Open' : 'Closed' }}</p>
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

@endsection
