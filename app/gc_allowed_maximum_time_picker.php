<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_allowed_maximum_time_picker extends Model
{
    protected $fillable = [
        'picker', 'time_start', 'time_end', 'setup_by'
    ];
    public $timestamps = false;
}
