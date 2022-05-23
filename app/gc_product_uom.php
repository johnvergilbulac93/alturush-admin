<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_product_uom extends Model
{
    protected $fillable = [
        'uom_id','itemcode', 'UOM', 'qty_per_uom'
    ];
    
    public $timestamps = false;

    protected $guarded = [];


}
