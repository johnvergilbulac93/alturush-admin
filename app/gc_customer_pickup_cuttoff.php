<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_customer_pickup_cuttoff extends Model
{
    protected $fillable = [
        'start','end', 'id'
    ];
}
