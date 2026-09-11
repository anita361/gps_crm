<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotesLog extends Model
{
    protected $table = 'notes_logs';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = [];
}