<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class gc_product_item extends Model
{

    protected $fillable = [
        'itemcode', 'product_name','category_no','category_name','quantity','status','image'
    ];
    
    public $timestamps = false;

    protected $table = 'gc_product_items';

    public function items()
    {
           return $this->belongsTo('App\gc_item_log_available', 'itemcode', 'itemcode')
           ->where('store', Auth::user()->bunit_code);
    }
    public function item_not_available()
    {
           return $this->belongsTo('App\gc_item_log_available', 'itemcode', 'itemcode');
    }
    public function item_price()
    {
           return $this->hasMany('App\gc_product_price', 'itemcode', 'itemcode')
          ->where('status', 1);
    }

    protected $guarded = [];
    


}
