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
    ];
}
