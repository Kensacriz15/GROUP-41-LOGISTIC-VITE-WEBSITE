@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Recent Inventory Transactions</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th>Warehouse</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->product->sku }}</td>
                    <td>{{ $transaction->warehouse->name }}</td>
                    <td>{{ $transaction->transaction_type }}</td>
                    <td class="{{ ($transaction->transaction_type == 'OUT') ? 'text-danger' : 'text-success' }}">
                        {{ $transaction->quantity }}
                        @if($transaction->damaged_quantity)
                            <span class="badge bg-warning">Damaged</span>
                        @endif
                    </td>
                    <td>{{ $transaction->date->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
