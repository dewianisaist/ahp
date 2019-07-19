<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    protected $table = 'selections';
    
    public $fillable = ['registration_id', 'selection_schedule_id', 'knowledge_value', 'technical_value', 'recommendation', 
                        'impression_value', 'seriousness_value', 'confidence_value', 'communication_value',
                        'appearance_value', 'family_value', 'motivation_value', 'attitude_value',
                        'orientation_value', 'commitment_value', 'honesty_value', 'mental_value',
                        'economic_value', 'potential_value', 'note', 'final_score', 'ranking', 'status'];
                        
    public function registrant() {
        return $this->belongsTo('App\Http\Models\Registrant');
    }

    public function registration() {
        return $this->belongsTo('App\Http\Models\Registration');
    }

    public function criterias() {
        return $this->belongsToMany('App\Http\Models\Criteria', 'result_selection');
    }
}
