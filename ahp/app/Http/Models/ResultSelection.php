<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ResultSelection extends Model
{
    protected $table = 'result_selection';
    
    public $fillable = ['selection_id', 'criteria_id', 'value'];

    public $timestamps = false;

    public function criteria() {
        return $this->belongsTo('App\Http\Models\Criteria');
    }
    
    public function selection() {
        return $this->belongsTo('App\Http\Models\Selection');
    }
}
