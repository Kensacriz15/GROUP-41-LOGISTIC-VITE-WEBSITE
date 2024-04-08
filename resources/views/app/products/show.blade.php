@extends('layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Product Details</h1>
            </div>
            <div class="card-body">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <p>SKU: {{ $product->sku }}</p>
                <p>Current Stock: {{ $product->current_stock }}</p>
                <p>Unit of Measure: {{ $product->unit_of_measure }}</p>
                <p>Reorder Level: {{ $product->reorder_level }}</p>
                <p>Safety Stock: {{ $product->safety_stock }}</p>
                <p>Type: {{ $product->type }}</p>
                <h3>SKU Attributes</h3>
                <ul>
                    @foreach ($product->skus as $sku)
                        <li>
                            SKU: {{ $sku->sku }}
                            <ul>
                                @foreach ($sku->attributes as $attribute => $value)
                                    <li>{{ $attribute }}: {{ $value }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
                <h3>Warehouses</h3>
                <ul>
                    @foreach ($product->warehouses as $warehouse)
                        <li>
                            Warehouse: {{ $warehouse->name }}
                            <ul>
                                <li>Quantity: {{ $product->getStockInWarehouse($warehouse) }}</li>
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
