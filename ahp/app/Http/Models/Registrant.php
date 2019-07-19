<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    protected $table = 'registrants';

    public $fillable = ['user_id', 'address', 'phone_number', 'gender', 'place_birth', 'date_birth', 
                        'order_child', 'amount_sibling', 'religion', 'biological_mother_name', 
                        'father_name', 'parent_address'];

    protected $hidden = ['password'];

    public function user() {
        return $this->belongsTo('App\Http\Models\User');
    }

    public function registration() {
        return $this->hasOne('App\Http\Models\Registration');
    }

    public function selection() {
        return $this->hasOne('App\Http\Models\Selection');
    }
}
