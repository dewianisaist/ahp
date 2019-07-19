<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PairwiseComparison extends Model
{
    protected $table = 'pairwise_comparisons';
    
    public $fillable = ['criteria1_id', 'criteria2_id', 'value'];

    public function criteria1() {
        return $this->belongsTo('App\Http\Models\Criteria');
    }

    public function criteria2() {
        return $this->belongsTo('App\Http\Models\Criteria');
    }
}
