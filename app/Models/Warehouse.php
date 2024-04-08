<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
  protected $table = 'lms_g42_warehouses';
    protected $fillable = [
        'name', 'location', 'capacity'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
