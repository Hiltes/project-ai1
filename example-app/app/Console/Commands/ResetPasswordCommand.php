<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class ResetPasswordCommand extends Command
{
    protected $signature = 'reset:password {email}';
    protected $description = 'Wygeneruj token resetujący hasło i wypisz go w konsoli.';

    public function handle(): void
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("Nie znaleziono użytkownika o adresie: {$email}");
            return;
        }

        $token = Password::createToken($user);
        $this->info("Wygenerowano token resetujący hasło dla: {$user->email}");
        $this->line("Token: {$token}");
        $this->line("http://127.0.0.1:8000/reset-password/{$token}");

    }
}

// php artisan reset:password janek@example.com
