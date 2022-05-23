<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_product_price extends Model
{
    // public function importPrice()

    protected $fillable = [
      'price_id','itemcode', 'date', 'UOM', 'price', 'price_with_vat'
    ];
    
    public $timestamps = false;
    protected $guarded = [];
}
