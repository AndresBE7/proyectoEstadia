<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{
    use HasFactory;

    protected $table = 'chat';

    // Definir columnas rellenables
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'file',
        'status',
        'created_date',
    ];

    // Desactivar timestamps automáticos si solo usas created_date
    public $timestamps = false;

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}