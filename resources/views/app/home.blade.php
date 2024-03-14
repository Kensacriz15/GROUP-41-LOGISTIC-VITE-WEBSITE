@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
            <h2>Recent Procurement Requests (Approved)</h2>
                @foreach($requests as $request)
                <div class="col-md-4 mb-4">
                    <div class="card">
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
        <a href="{{ route('app.procurement.listrequest', $request) }}" class="btn btn-lg btn-info">Show More</a>
    </div>
</div>
@endsection
