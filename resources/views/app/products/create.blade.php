@extends('layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Add Product</h1>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('app.products.store') }}" method="POST">
                    @csrf
                    <!-- Card Fields: Name, Description, etc... -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="current_stock">Current Stock</label>
                        <input type="number" name="current_stock" id="current_stock" class="form-control" min="0" value="0">
                    </div>

                    <div class="form-group">
                        <label for="unit_of_measure">Unit of Measure</label>
                        <input type="text" name="unit_of_measure" id="unit_of_measure" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="reorder_level">Reorder Level</label>
                        <input type="number" name="reorder_level" id="reorder_level" class="form-control" min="0">
                    </div>

                    <div class="form-group">
                        <label for="safety_stock">Safety Stock</label>
                        <input type="number" name="safety_stock" id="safety_stock" class="form-control" min="0">
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="raw_material">Raw Material</option>
                            <option value="component">Component</option>
                            <option value="finished_good">Finished Good</option>
                        </select>
                    </div>

                    <!-- SKU Fields -->
                    <h3>SKU Attributes</h3>
                    <div id="sku-attributes-container">
                        <div class="attribute-entry">
                            <div class="form-group">
                                <label for="attribute_name_1">Attribute Name</label>
                                <input type="text" name="attribute_names[]" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="attribute_value_1">Attribute Value</label>
                                <input type="text" name="attribute_values[]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-attribute" class="btn btn-primary">Add Attribute</button>

                    <div id="sku-container">
                        <div class="form-group">
                            <label for="sku">SKU</label>
                            <input type="text" name="sku" id="sku" class="form-control" required>
                        </div>
                    </div>

                    <button type="button" id="add-sku" class="btn btn-primary">Add Another SKU</button>

                    <div id="warehouses-container">
                        <label>Warehouses</label>
                        <div class="warehouse-entry">
                            <select name="warehouses[]" class="form-control warehouse-select">
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="quantities[]" class="form-control quantity-input" min="0" placeholder="Quantity">
                        </div>
                    </div>

                    <button type="button" id="add-warehouse" class="btn btn-primary">Add Another Warehouse</button>

                    <button type="submit" class="btn btn-success">Save Product</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card {
            max-width: 1500px;
            margin: 0 auto;
        }
    </style>

    <script>
        document.getElementById('add-attribute').addEventListener('click', function() {
            let container = document.getElementById('sku-attributes-container');
            let newEntry = container.lastElementChild.cloneNode(true);
            let inputCount = container.querySelectorAll('input').length + 1;

            // Update input field names to be unique
            newEntry.querySelectorAll('input').forEach(input => {
                let oldName = input.getAttribute('name');
                input.setAttribute('name', oldName.replace(/\d+$/, inputCount));
            });

            // Clear input values
            newEntry.querySelectorAll('input').forEach(input => input.value = '');

            container.appendChild(newEntry);
        });

        document.getElementById('add-sku').addEventListener('click', function() {
            let container = document.getElementById('sku-container');
            let newEntry = container.lastElementChild.cloneNode(true);

            // Clear value in the cloned field
            newEntry.querySelector('input').value = '';

            container.appendChild(newEntry);
        });

        document.getElementById('add-warehouse').addEventListener('click', function() {
            let container = document.getElementById('warehouses-container');
            let newEntry = container.lastElementChild.cloneNode(true); // Clone the last entry

            // Clear values in the cloned fields
            newEntry.querySelector('.warehouse-select').value = '';
            newEntry.querySelector('.quantity-input').value = '';

            container.appendChild(newEntry);
        });
    </script>
@endsection
