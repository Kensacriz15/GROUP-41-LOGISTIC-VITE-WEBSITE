<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Table Name (optional, if it follows conventions)
    protected $table = 'lms_g49_suppliers';

    // Fields you want to allow mass-assignment for
    protected $fillable = [
        'supplier_name',
        'address',
        'city',
        'zip_code',
        'contact_name',
        'email',
        'phone',
        'status'
    ];
}
