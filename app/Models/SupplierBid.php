<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierBid extends Model
{
  protected $table = 'supplier_bids';

  protected $fillable = ['name', 'supplier_id', 'bidding_product_id', 'quantity', 'proposed_price', 'product_description', 'status', 'supporting_document'];

  public function bids()
  {
      return $this->hasMany(SupplierBid::class);
  }
}
