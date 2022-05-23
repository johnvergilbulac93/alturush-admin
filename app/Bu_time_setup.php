<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bu_time_setup extends Model
{
    protected $table = 'bu_time_setups';

    protected $fillable = [
        'bunit_code', 'time_in','time_out','status'
    ];
    
}
