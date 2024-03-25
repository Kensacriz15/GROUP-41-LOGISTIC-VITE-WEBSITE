@extends('layouts/layoutMaster')

@section('content')
<h1>Invoices</h1>

@if(session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif
<div class="budget-info">
    Available Budget: {{ $budget ?? 'Budget Not Set' }}
</div>
<table>
    <thead>
        <tr>
            <th>Invoice Number</th>
            <th>Bidder</th>
            <th>Total</th>
            <th>Amount Paid</th>
            <th>Balance</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->bid->supplier->supplier_name ?? $invoice->bid->vendor->vendor_name ?? 'Unknown' }}</td>
                <td>{{ $invoice->total }}</td>
                <td>{{ $invoice->amount_paid }}</td>
                <td>{{ $invoice->balance }}</td>
                <td>
                    <a href="{{ route('viewInvoice', $invoice->id) }}" target="_blank">View</a>
                    <a href="{{ route('app.procurement.invoices.edit', $invoice->id) }}">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
