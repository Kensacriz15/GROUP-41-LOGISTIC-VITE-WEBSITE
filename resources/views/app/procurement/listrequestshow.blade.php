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
 <p class="card-text">
     <strong>Name:</strong>
     {{ $request->request_data['requester_info']['name'] ?? 'Not Available' }}
 </p>
 <p class="card-text">
 <strong>Contact:</strong><br>
Address: {{ $request->request_data['requester_info']['contact']['address'] ?? 'Not Available' }}<br>
Phone: {{ $request->request_data['requester_info']['contact']['phone'] ?? 'Not Available' }}

 <h5 class="card-title">Request Items</h5>
 <ul>
     @if (isset($request->request_data['items']))
         @foreach ($request->request_data['items'] as $item)
             <li>
                 <strong>Product Name:</strong> {{ $item['product_name'] }} <br>
                 <strong>Description:</strong>
                 {!! $item['description']  !!}  {{-- Use with caution if you trust HTML in descriptions --}}
                 <strong>Quantity:</strong> {{ $item['quantity'] }}
             </li>
         @endforeach
     @else
         <li>No items found.</li>
     @endif
 </ul>

  <h5 class="card-title">Justification</h5>
  <p class="card-text">{{ $request->request_data['justification'] }}</p>
        </div>
    </div>
</div>

@endsection
