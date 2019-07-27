<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'score';
    
    public $fillable = ['alternative_id', 'criteria_id', 'value'];

    public $timestamps = false;

    public function criteria() {
        return $this->belongsTo('App\Http\Models\Criteria');
    }
    
    public function alternative() {
        return $this->belongsTo('App\Http\Models\Alternative');
    }
}
