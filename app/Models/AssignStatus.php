<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignStatus extends Model
{
    protected $table = 'assign_status';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'seminar_id',
        'counelor_id',
        'status',
        'created_date',
        'created_time'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function seminar()
    {
        return $this->belongsTo(SeminarPre::class, 'seminar_id', 'sno');
    }

    public function counselor()
    {
        return $this->belongsTo(CrmLogin::class, 'counelor_id', 'id');
    }
}