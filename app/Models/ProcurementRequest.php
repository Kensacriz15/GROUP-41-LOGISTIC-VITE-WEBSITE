<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementRequest extends Model
{
  protected $table = 'lms_g41_procurement_requests';
    protected $fillable = [
        'user_id', 'department_id', 'request_origin', 'status',
        'external_request_id', 'request_data'
    ];

    protected $casts = [
        'request_data' => 'array' // Automatically handle JSON
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
