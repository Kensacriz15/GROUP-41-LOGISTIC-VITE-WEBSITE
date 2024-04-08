@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Inventory Alerts</h4>
    </div>
    <div class="card-body">
        @if($lowStockProducts->count())
            <ul>
                @foreach($lowStockProducts as $product)
                    <li>
                        <span class="badge badge-light-danger"><i class="ti-alert me-50"></i></span>
                        {{ $product->name }} (Stock: {{ $product->current_stock }})
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-success">No critical alerts at this time.</p>
        @endif
    </div>
</div>
@endsection
