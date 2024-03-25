@extends('layouts/layoutMaster')

@section('content')
    <h1>Edit Invoice #{{ $invoice->invoice_number }}</h1>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('updateInvoice', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h2>Invoice Details</h2>
        <table>
            <tbody>
                <tr>
                    <td>Invoice Date:</td>
                    <td>{{ $invoice->invoice_date }}</td>
                </tr>
                <tr>
                    <td>Purchase Order:</td>
                    <td>{{ $invoice->po_number }}</td>
                </tr>
                <tr>
                    <td>Shipping Date:</td>
                    <td>{{ $invoice->shipping_date }}</td>
                </tr>
            </tbody>
        </table>

        <h2>Items</h2>
        <table class="items-table">
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
                            <input type="text" name="items[{{ $index }}][description]" value="{{ $item['description'] }}">
                        </td>
                        <td>
                            <input type="number" name="items[{{ $index }}][qty]" value="{{ $item['qty'] }}">
                        </td>
                        <td>
                            <input type="number" name="items[{{ $index }}][price]" value="{{ $item['price'] }}">
                        </td>
                        <td>{{ $item['qty'] * $item['price'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Seller Details</h2>
        <table>
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
        <table>
            <tbody>
                <tr>
                    <td>Subtotal:</td>
                    <td><input type="number" name="subtotal" value="{{ $invoice->subtotal }}"></td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td><input type="number" name="tax" value="{{ $invoice->tax }}"></td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td><input type="number" name="total" value="{{ $invoice->total }}"></td>
                </tr>
                <tr>
    <td>Amount Paid:</td>
    <td><input type="number" name="amount_paid" value="{{ $invoice->amount_paid }}"></td>
</tr>
            </tbody>
        </table>

        <button type="submit">Save</button>
    </form>
@endsection
