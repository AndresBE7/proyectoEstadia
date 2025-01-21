<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarModel extends Model
{
    use HasFactory;
    // Nombre de la tabla asociada
    protected $table = 'calendar';

    protected $fillable = [
        'user_id',
        'title',
        'start',
        'end',
        'allDay',
    ];
}
