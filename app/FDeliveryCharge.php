<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FDeliveryCharge extends Model
{
    public function barangay()
    {
        return $this->belongsTo('App\Barangay', 'brgy_id', 'brgy_id');
    }

    protected $table = 'tbl_delivery_charges';

    protected $guarded = [];
}
