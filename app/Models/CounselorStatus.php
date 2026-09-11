<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselorStatus extends Model
{
    protected $table = 'counslor_status';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = [];

    public function lead()
    {
        return $this->belongsTo(SeminarPre::class, 'seminar_id', 'sno');
    }
}