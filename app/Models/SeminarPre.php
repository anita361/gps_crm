<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeminarPre extends Model
{
  
    protected $table = 'seminarpre';

    
    protected $primaryKey = 'sno';

    
    public $timestamps = false;

    
    protected $keyType = 'int';

    
    public $incrementing = true;

   
    protected $guarded = [];
}