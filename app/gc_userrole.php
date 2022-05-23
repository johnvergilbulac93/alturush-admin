<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_userrole extends Model
{
    protected $table = 'user_roles';

    public function users()
    {
    return $this->belongsToMany('App\User');
    }

}
