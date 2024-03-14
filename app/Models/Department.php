<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name'
    ];
    protected $table = 'lms_g41_departments';

    // Relationship with Procurement Requests (one-to-many)
    public function procurementRequests()
    {
        return $this->hasMany(ProcurementRequest::class);
    }
}
