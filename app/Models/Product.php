<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'lms_g41_products';

    protected $fillable = ['name', 'description', 'sku', 'current_stock', 'unit_of_measure', 'reorder_level', 'safety_stock', 'type'];

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class);
    }

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }

    public function getCurrentStockAttribute()
    {
        return $this->inventoryTransactions()->sum('quantity');
    }

    public function getStockInWarehouse(Warehouse $warehouse)
    {
        return $this->inventoryTransactions()
                    ->where('warehouse_id', $warehouse->id)
                    ->sum('quantity');
    }
}
