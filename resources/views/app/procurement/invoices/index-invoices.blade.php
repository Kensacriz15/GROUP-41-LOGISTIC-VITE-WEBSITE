@extends('layouts/layoutMaster')

@section('content')
<div class="row">
    <div class="col-lg-9">
        <h1>Invoices</h1>
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
    </div>

    @php
        $totalAmountPaid = $invoices->sum('amount_paid');
        $invoiceBalance = $currentBudget - $totalAmountPaid;
    @endphp

    <div class="col-lg-3 text-center"> <div class="card h-100">
            <div class="card-body">
                <h6>Invoice Balance</h6>
                <i class="fa-solid fa-peso-sign ti-sm"></i>
                {{ $invoiceBalance }}
            </div>
        </div>
    </div>
</div>

<div class="row mt-4"> <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Bidder</th>
                    <th>Total</th>
                    <th>Amount Paid</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->bid->supplier->supplier_name ?? $invoice->bid->vendor->vendor_name ?? 'Unknown' }}</td>
                    <td>₱ {{ $invoice->total }}</td>
                    <td>₱ {{ $invoice->amount_paid }}</td>
                    <td>{{ $invoice->status }}</td>
                                           <td>
                            <a href="{{ route('viewInvoice', $invoice->id) }}" target="_blank"
                               class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('app.procurement.invoices.edit', $invoice->id) }}"
                               class="btn btn-sm btn-success">Edit</a>

                            @if($invoice->status != 'Paid')
                                <form method="POST"
                                      action="{{ route('app.procurement.invoices.payment', $invoice->id) }}"
                                      style="display: inline">
                                    @csrf
                                    <div class="form-group">
                                        <input type="number" step="0.01" name="amount_paid" class="form-control"
                                               placeholder="Enter Amount">
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success">Pay</button>
                                </form>
                            @endif
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
