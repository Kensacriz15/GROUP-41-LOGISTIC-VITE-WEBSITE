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
@endsection
