@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card alert-card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white">Inventory Alerts</h4>
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
    </div>
    <div class="col-md-3">
         <div class="card value-card">
            <div class="card-header bg-success">
                <h4 class="card-title text-white">Total Stock Value</h4>
            </div>
            <div class="card-body">
                <h3 class="text-center">{{ $totalStockValue }}</h3>
                <p class="text-center"><i class="ti-arrow-up text-success"></i></p>
            </div>
         </div>
    </div>
    <div class="row">
    <div class="col-md-3">
        <div class="card top-products-card">
            <div class="card-header">
                <h4 class="card-title">Top Products (By Quantity Sold)</h4>
            </div>
            <div class="card-body">
                <div id="topProductsChart"></div> </div>
        </div>
    </div>

    </div>
<div class="row">
    <div class="col-12">
        <div class="card transaction-card">
            <div class="card-header">
                <h4 class="card-title">Recent Activity</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Warehouse</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->product->name }}</td>
                            <td>{{ $transaction->warehouse->name }}</td>
                            <td class="{{ ($transaction->transaction_type == 'OUT') ? 'text-danger' : 'text-success' }}">
                                {{ $transaction->transaction_type }}
                            </td>
                            <td>{{ $transaction->quantity }}</td>
                            <td>{{ $transaction->date->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No transactions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
