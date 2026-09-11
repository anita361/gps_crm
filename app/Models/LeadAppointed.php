<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadAppointed extends Model
{
    protected $table = 'lead_appointed';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [

        'assign_name',
        'assign_id',
        'assign_date',

        'seminar_id',

        'userid',

        'callerno',

        'walkin_status',

        'applicant_name',

        'marital_status',

        'gender',

        'husband_name',

        'wife_name',

        'created_date',

        'created_time',

        'created_by'
    ];
}