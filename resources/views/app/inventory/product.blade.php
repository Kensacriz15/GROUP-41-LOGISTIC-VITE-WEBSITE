@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ $product->name }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p>SKU: {{ $product->sku }}</p>
                <p>Current Total Stock: {{ $product->current_stock }}</p>
            </div>
            <div class="col-md-6">
                <p> </p>
            </div>
        </div>
    </div>
</div>
@endsection
