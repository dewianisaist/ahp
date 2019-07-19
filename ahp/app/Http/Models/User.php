<?php

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'identity_number', 'email', 'password',
    ];

    public function criterias() {
        return $this->belongsToMany('App\Http\Models\Criteria', 'choice');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roleId() {
        if (session()->has('role_id')) {
            return session('role_id');
        } else {
            return 0;
        }
    }

    /**
     * @param  int  $id
     */
    public function setRoleId($id) {
        session(['role_id' => $id]);
    }

    public function registrant() {
        return $this->hasOne('App\Http\Models\Registrant');
    }
}
