<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Survey extends Model
{
    protected $fillable = [
        'title',
        'description',
        'questions',
        'groups',
        'expiration_date',
        'is_active'
    ];

    protected $casts = [
        'questions' => 'array',
        'groups' => 'array',
        'is_active' => 'boolean',
        'expiration_date' => 'datetime',
    ];

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('expiration_date', '>', Carbon::now());
    }

    public function isExpired()
    {
        return $this->expiration_date->isPast();
    }

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($survey) {
            // Desactivar automáticamente si está expirada
            if ($survey->isExpired()) {
                $survey->is_active = false;
            }
        });
    }
}