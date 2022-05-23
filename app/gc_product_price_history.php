<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_product_price_history extends Model
{
    //gc_product_price_histories
    protected $fillable = [
        'itemcode', 'price','UOM','update_at'
    ];
    
    public $timestamps = false;

    protected $table = 'gc_product_price_histories';

    public function description()
    {
        return $this->belongsTo('App\gc_product_item', 'itemcode', 'itemcode');
    }

    protected $guarded = [];

    
}
