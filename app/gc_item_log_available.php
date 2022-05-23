<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class gc_item_log_available extends Model
{
    protected $fillable = [
        'itemcode', 'status','store','tag_by'
    ];

    protected $guarded = [];
    protected $table = 'gc_item_log_availables';

    public function item_price()
    {
           return $this->hasMany('App\gc_product_price', 'itemcode', 'itemcode')
          ->where('status', 1);
    }

}