<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest; // We'll create this request later
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with('warehouses')->paginate(10); // Fetch products with warehouse relationships
        return view('app.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(Request $request)
{
    $warehouses = Warehouse::all();

    $attributeNames = $request->attribute_names ?? [];
    $attributeValues = $request->attribute_values ?? [];

    $attributes = [];
    for ($i = 0; $i < count($attributeNames); $i++) {
        $attributes[$attributeNames[$i]] = $attributeValues[$i];
    }

    return view('app.products.create', compact('warehouses'));
}

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request)
{
    $product = Product::create($request->validated());

    // Warehouse Association Logic
    $warehouses = $request->warehouses;
    $quantities = $request->quantities;

    for ($i = 0; $i < count($warehouses); $i++) {
        $warehouse = Warehouse::find($warehouses[$i]);
        if($warehouse) { // Check if warehouse exists
            $product->warehouses()->attach($warehouse, ['quantity' => $quantities[$i]]);
        }
    }

// SKU Attribute Handling
$attributeNames = $request->attribute_names;
$attributeValues = $request->attribute_values;

$attributes = [];
for ($i = 0; $i < count($attributeNames); $i++) {
    $attributes[$attributeNames[$i]] = $attributeValues[$i];
}

// Create the SKU and associate it with the product
$sku = Sku::create([
    'product_id' => $product->id,
    'sku' => $request->sku,
    'attributes' => json_encode($attributes)
]);

    return redirect()->route('app.products.index')->with('success', 'Product created!');
}

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('app.products.show', compact('product'));
    }

    /**
     * Show the form for editing the product.
     */
    public function edit(Product $product)
    {
        return view('app.products.edit', compact('product'));
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('app.products.index')->with('success', 'Product updated!');
    }

    /**
     * Remove the specified product (Soft Delete).
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('app.products.index')->with('success', 'Product deleted!');
    }
}
