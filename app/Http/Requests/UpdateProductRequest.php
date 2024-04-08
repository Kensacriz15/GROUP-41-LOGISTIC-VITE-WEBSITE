<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    // ... (Similar to StoreProductRequest) ...

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku,'.$this->product->id // Unique except for the current product
            // ... Add rules for your other product fields ...
        ];
    }
}
