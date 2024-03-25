<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    protected $fillable = ['bidding_product_id', 'bid_id', /* ... other fields */];

    public function biddingProduct()
    {
        return $this->belongsTo(BiddingProduct::class);
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
            // Assumes 'supplier_id' is the foreign key on 'winners' table
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
            // Assumes 'supplier_id' is the foreign key on 'winners' table
    }
}
