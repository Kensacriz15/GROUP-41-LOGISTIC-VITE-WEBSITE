<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    // Table Name (optional, if it follows conventions)
    protected $table = 'lms_g49_vendors';

    // Fields you want to allow mass-assignment for
    protected $fillable = [
        'vendor_name',
        'address',
        'city',
        'zip_code',
        'contact_name',
        'email',
        'phone',
        'status'
    ];
}
