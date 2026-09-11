<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'lead_appointed';

    protected $fillable = [
        'callerno',
        'walkin_status',
        'applicant_name',
        'created_date',
        'created_time',
        'email',
        'lead_from',
        'lead_remarsk'
    ];

    public $timestamps = false;
}