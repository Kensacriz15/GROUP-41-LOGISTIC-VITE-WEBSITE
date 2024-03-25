<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px;}
        td, th { border: 1px solid #ddd; padding: 10px; }
        h1, h2 { text-align: center; margin-bottom: 15px; }
        .header-container { display: flex; align-items: center; }
        .logo-container { margin-right: 20px; }
        .logo-container img { width: 200px; }
        .company-info { font-weight: bold; }
    </style>
</head>
<body>
<div class="header-container">
    <div class="logo-container">
    <img src="{{ public_path('images/logo.png') }}" alt="Logo">
    </div>

    <h1>Invoice #{{ $invoice->invoice_number }}</h1>
</div>

<div class="company-info">
    <p>bbox express</p>
    <p>Novaliches, Quezon City</p>
    <p>09109091234</p>
</div>

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
        @foreach ($invoice->items as $item)
        <tr>
            <td>{{ $item['description'] }}</td>
            <td>{{ $item['qty'] }}</td>
            <td>{{ $item['price'] }}</td>
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
            <td>{{ $invoice->subtotal }}</td>
        </tr>
        <tr>
            <td>Tax:</td>
            <td>{{ $invoice->tax }}</td>
        </tr>
        <tr>
            <td>Total:</td>
            <td>{{ $invoice->total }}</td>
        </tr>
        <tr>
            <td>Amount Paid:</td>
            <td>{{ $invoice->amount_paid }}</td>
        </tr>
    </tbody>
</table>
</body>
</html>
