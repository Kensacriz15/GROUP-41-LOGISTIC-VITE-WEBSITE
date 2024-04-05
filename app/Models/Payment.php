<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $table = 'lms_g41_payments';
    protected $fillable = ['invoice_id', 'amount', 'date',];

    public function invoice()
    {
         return $this->belongsTo(Invoice::class);
    }
}
