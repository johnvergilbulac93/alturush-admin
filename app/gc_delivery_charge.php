<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_delivery_charge extends Model
{
    protected $fillable = [
       'prov_id', 'town_id','brgy_id','transpo_id','charge_amt','rider_shared','status',
    ];
    public function provinces()
    {
           return $this->belongsTo('App\Province', 'prov_id', 'prov_id');
    }
    public function towns()
    {
           return $this->belongsTo('App\Town', 'town_id', 'town_id');
    }
    public function brgy()
    {
           return $this->belongsTo('App\Barangay', 'brgy_id', 'brgy_id');
    }
    public function transports()
    {
           return $this->belongsTo('App\gc_transportation', 'transpo_id', 'id');
    }

    protected $table = 'gc_delivery_charges';
}
