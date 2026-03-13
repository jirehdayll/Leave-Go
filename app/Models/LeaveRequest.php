<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'type',
        'office',
        'name',
        'date_filling',
        'position',
        'salary',
        'status',
        'is_starred',
        'details',
    ];

    protected $casts = [
        'details' => 'array',
        'date_filling' => 'date',
        'is_starred' => 'boolean',
    ];
}
