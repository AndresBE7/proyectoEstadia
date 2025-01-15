<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdatePasswords extends Command
{
    protected $signature = 'update:passwords';
    protected $description = 'Actualizar las contraseñas a bcrypt';

    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (!Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password);
                $user->save();
                $this->info("Contraseña actualizada para {$user->email}");
            }
        }
        $this->info('Todas las contraseñas han sido actualizadas.');
    }
}
