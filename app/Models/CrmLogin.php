<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrmLogin extends Model
{
    protected $table = 'crm_login';

    protected $fillable = [
        'username',
        'password',
        'role'
    ];

    public $timestamps = false;
}