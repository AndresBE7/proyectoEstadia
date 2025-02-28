<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static public function getAdmin(){
        return self::select('users.*')
            ->where('user_type', '=', '1')
            ->where('is_delete', '=', '0') // Solo usuarios activos
            ->orderBy('id', 'desc')
            ->get();
    }

    static public function getStudent() {
        return self::select('users.*')
            ->where('users.user_type', '=', '3')
            ->where('users.is_delete', '=', '0') // Solo usuarios activos
            ->orderBy('users.id', 'desc') // Ordenar por ID de forma descendente
            ->paginate(20); // Paginación de 20 registros
    }

    static public function getParent() {
        return self::select('users.*')
            ->where('users.user_type', '=', '4')
            ->where('users.is_delete', '=', '0') // Solo usuarios activos
            ->orderBy('users.id', 'desc') // Ordenar por ID de forma descendente
            ->get();    

    }

    static public function getTeacher() {
        return self::select('users.*')
            ->where('users.user_type', '=', '2')
            ->where('users.is_delete', '=', '0') // Solo usuarios activos
            ->orderBy('users.id', 'desc') // Ordenar por ID de forma descendente
            ->get();    
    }


    static public function getMyStudent($parent_id){
    $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
        ->join('users as parent', 'parent.id', '=', 'users.parent_id')
        ->join('class', 'class.id', '=', 'users.class_id', 'left')
        ->where('users.user_type', '=', 3)
        ->where('users.parent_id', '=', $parent_id)
        ->where('users.is_delete', '=', 0)
        ->orderBy('users.id', 'desc')
        ->get();

        return $return;
    }

    
    static public function getSingle($id){
        return self::find($id);
    }

    static public function getEmailSingle($email){
        return User::where('email', '=', $email)->first();
    }

    static public function getTokenSingle($remember_token){
        return User::where('remember_token', $remember_token)->first();
    }

    // En app/Models/User.php
    public function students()
    {
        return $this->hasMany(User::class, 'parent_id')
                    ->where('user_type', 3)
                    ->where('is_delete', 0);
    }

    // Relación: Tutor de un estudiante
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id')
                    ->where('user_type', 4)
                    ->where('is_delete', 0);
    }

    // Relación: Grupos del estudiante (muchos a muchos)
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_student', 'student_id', 'class_id')
                    ->where('class.is_delete', 0);
    }
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }
    
    public function taughtGrades()
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }

    
}
