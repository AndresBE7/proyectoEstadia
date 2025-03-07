<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $fillable = [
        'survey_id',
        'user_id',
        'answers'
    ];

    protected $casts = [
        'answers' => 'array'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}