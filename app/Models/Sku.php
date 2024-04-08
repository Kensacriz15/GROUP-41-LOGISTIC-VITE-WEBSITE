<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
  protected $table = 'lms_g41_skus';
    protected $fillable = [
        'product_id', 'sku', 'attributes'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
