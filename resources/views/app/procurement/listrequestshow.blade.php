@extends('layouts/layoutMaster')

@section('title', 'Procurement Request Details')

@section('content')
<div class="container">
    <h1>Procurement Request Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Request ID: {{ $request->external_request_id }}</h5>
            <p class="card-text"><strong>Status:</strong> {{ $request->status }}</p>
            <p class="card-text"><strong>Department:</strong> {{ $request->department->name }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $request->created_at->format('m/d/Y') }}</p>
            <h5 class="card-title">Requester Information</h5>
            <p class="card-text"><strong>Name:</strong> {{ $request->request_data['requester_info']['name'] ?? 'Not Available' }}</p>
            <p class="card-text"><strong>Contact:</strong> {{ $request->request_data['requester_info']['contact'] ?? 'Not Available' }}</p>
            <h5 class="card-title">Request Items</h5>
            <ul>
            @foreach ($request->request_data['items'] as $item)
            <li>
              <strong>Product Name:</strong> {{ $item['product_name'] }} <br>
              <strong>Description:</strong> {{ $item['description'] }} <br>
              <strong>Quantity:</strong> {{ $item['quantity'] }}
          </li>
      @endforeach
  </ul>

  <h5 class="card-title">Justification</h5>
  <p class="card-text">{{ $request->request_data['justification'] }}</p>
        </div>
    </div>
</div>
@endsection
