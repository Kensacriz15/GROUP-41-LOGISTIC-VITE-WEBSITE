<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
      'start_date' => 'date',   // Adjust only if you were casting it differently before
      'end_date' => 'date'
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
public function isOpen()
{
    $now = now();
    $result = $now->gte($this->start_date) && $now->lte($this->end_date);
    return $result;
}

}
