<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;
    protected $table = 'lms_g49_bids';
    protected $fillable = ['bidding_product_id', 'supplier_id', 'vendor_id', 'amount']; // Removed 'lms_g41_users_id'

    public function biddingProduct()
    {
        return $this->belongsTo(\App\Models\BiddingProduct::class, 'bidding_product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

}
