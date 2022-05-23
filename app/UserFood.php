<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UserFood extends Model
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'username'
    ];

    protected $hidden = [
        'password', 'email', 'remember_token',
    ];

    protected $table = 'users';

    public function roles()
    {
        return $this->belongsToMany('App\UserType', 'user_roles', 'user_id', 'usertype_id');
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where(['usertype_id' => $role, 'user_roles.status' => true])->first()) {
            return true;
        }
        return false;
    }
}
