<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlobalCategory extends Model
{
    protected $table = 'global_categories';

    public function check_cat()
    {
        return $this->hasMany('App\GlobalCatUnavailable', 'category_id', 'id');
    }
    public function discount()
    {
        return $this->hasMany('App\Discount', 'id', 'global_cat_id');
    }
}
