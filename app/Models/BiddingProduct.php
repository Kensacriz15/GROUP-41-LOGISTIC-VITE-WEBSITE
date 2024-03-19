<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingProduct extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'lms_g41_bidding_products';

    // Fields you want to allow mass assignment for
    protected $fillable = [
        'name',
        'description',
        'starting_price',
        'image',
        'start_date',
        'end_date',
        'product_data',
        'external_request_id'
    ];

    protected $casts = [
        'product_data' => 'array',
        'start_date' => 'datetime:Y-m-d', // Adjust format if necessary
        'end_date' => 'datetime:Y-m-d'

    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
    public function biddingProduct()
    {
      return $this->hasMany(BiddingProduct::class);
    }
    public function lowestBid()
{
     return $this->hasOne(Bid::class)->orderBy('amount');
}
}
