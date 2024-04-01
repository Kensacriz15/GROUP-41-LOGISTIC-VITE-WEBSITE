<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'company_name',
        'company_address',
        'company_phone',
        'invoice_date',
        'due_date',
        'invoice_to_name',
        'invoice_to_company_name',
        'invoice_to_address',
        'invoice_to_phone',
        'invoice_to_email',
        'subtotal',
        'discount',
        'total',
        'notes',
        'amount_paid',
        'balance',
        'status',
    ];

    protected $casts = [
      'items' => 'array',
  ];

  public function bid()
  {
      return $this->belongsTo(Bid::class); // Assuming a one-to-one
  }
  public function isPaid()
{
    return $this->balance <= 0;
}
public function payments()
{
    return $this->hasMany(Payment::class);
}
}
