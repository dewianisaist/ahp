<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $table = 'alternatives';

    public $fillable = ['name', 'date_birth', 'last_education', 'intensity_participation', 
                        'course_experience', 'orientation_value', 'recommendation', 
                        'knowledge_value', 'technical_value', 'honesty_value', 'attitude_value',
                        'motivation_value', 'mental_value', 'family_value', 'appearance_value',
                        'communication_value', 'confidence_value', 'commitment_value',
                        'economic_value', 'potential_value', 'seriousness_value', 'impression_value',
                        'score_ahp', 'score_promethee', 'rank_ahp', 'rank_promethee'];

    public function criterias() {
        return $this->belongsToMany('App\Http\Models\Criteria', 'score');
    }
}
