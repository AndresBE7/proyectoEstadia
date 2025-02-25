<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Survey extends Model
{
    protected $fillable = [
        'title', 'description', 'questions', 'expiration_date', 'is_active'
    ];
    
    protected $casts = [
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
        return $this->expiration_date ? $this->expiration_date->isPast() : false;
    }

    public function getQuestionsAttribute($value)
    {
        if (is_array($value)) {
            return $value; // Si ya es un array, no hacemos nada
        }
    
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded; // Si es JSON válido, lo devolvemos como array
            }
            // Si no es JSON, asumimos que es una cadena separada por comas
            return array_filter(array_map('trim', explode(',', $value))); // Filtramos valores vacíos
        }
    
        return []; // Default si no es ni string ni array
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