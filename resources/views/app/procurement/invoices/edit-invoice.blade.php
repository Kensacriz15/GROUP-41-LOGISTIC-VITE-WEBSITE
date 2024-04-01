@extends('layouts/layoutMaster')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Invoice #') }}{{ $invoice->invoice_number }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="success-message">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('updateInvoice', $invoice->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h2>Invoice Details</h2>
                        <div class="form-group row">
                            <label for="invoice_date" class="col-md-4 col-form-label text-md-right">{{ __('Invoice Date') }}</label>
                            <div class="col-md-6">
                                <input id="invoice_date" type="date" class="form-control @error('invoice_date') is-invalid @enderror" name="invoice_date" value="{{ $invoice->invoice_date }}" required autofocus>
                                @error('invoice_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="po_number" class="col-md-4 col-form-label text-md-right">{{ __('Purchase Order') }}</label>
                            <div class="col-md-6">
                                <input id="po_number" type="text" class="form-control @error('po_number') is-invalid @enderror" name="po_number" value="{{ $invoice->po_number }}" required>
                                @error('po_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="shipping_date" class="col-md-4 col-form-label text-md-right">{{ __('Shipping Date') }}</label>
                            <div class="col-md-6">
                                <input id="shipping_date" type="date" class="form-control @error('shipping_date') is-invalid @enderror" name="shipping_date" value="{{ $invoice->shipping_date }}" required>
                                @error('shipping_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <h2>Items</h2>
                        <table class="table items-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->items as $index => $item)
                                    <tr>
                                        <td>
                                            <input type="text" name="items[{{ $index }}][description]" value="{{ $item['description'] }}" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][qty]" value="{{ $item['qty'] }}" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][price]" value="{{ $item['price'] }}" class="form-control">
                                        </td>
                                        <td>{{ $item['qty'] * $item['price'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h2>Seller Details</h2>
                        <table class="table">
                            <tbody>
                                @if ($invoice->bid->vendor)
                                    <tr>
                                        <td>Seller Type:</td>
                                        <td>Vendor</td>
                                    </tr>
                                    <tr>
                                        <td>Seller Name:</td>
                                        <td>{{ $invoice->bid->vendor->vendor_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Seller Address:</td>
                                        <td>{{ $invoice->bid->vendor->Address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Seller Phone:</td>
                                        <td>{{ $invoice->bid->vendor->phone }}</td>
                                    </tr>
                                @elseif ($invoice->bid->supplier)
                                    <tr>
                                        <td>Seller Type:</td>
                                        <td>Supplier</td>
                                    </tr>
                                    <tr>
                                        <td>Seller Name:</td>
                                        <td>{{ $invoice->bid->supplier->supplier_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Seller Address:</td>
                                        <td>{{ $invoice->bid->supplier->Address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Seller Phone:</td>
                                        <td>{{ $invoice->bid->supplier->Phone }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="2">Seller details not available</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <h2>Billing Summary</h2>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Subtotal:</td>
                                    <td><input type="number" name="subtotal" value="{{ $invoice->subtotal }}" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Tax:</td>
                                    <td><input type="number" name="tax" value="{{ $invoice->tax }}" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Total:</td>
                                    <td><input type="number" name="total" value="{{ $invoice->total }}" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Amount Paid:</td>
                                    <td><input type="number" name="amount_paid" value="{{ $invoice->amount_paid }}" class="form-control"></td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
