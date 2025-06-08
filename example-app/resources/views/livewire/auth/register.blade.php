<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:8')]
    public string $password = '';

    #[Validate('required|string|same:password')]
    public string $password_confirmation = '';

    public function register(): void
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'customer',
        ]);

        Auth::login($user);

        $this->redirect(route('home'), navigate: true);
    }
}; ?>

<div class="w-full sm:max-w-md bg-white p-6 sm:p-8 rounded-lg shadow">

    <x-auth-header :title="__('Zarejestruj się')" :description="__('Utwórz nowe konto w serwisie')" />

    <form wire:submit="register" class="flex flex-col gap-2">

        <flux:input
            wire:model="name"
            :label="__('Imię i nazwisko')"
            type="text"
            required
            autocomplete="name"
            placeholder="Jan Kowalski"
            class="border border-black"

        />

        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
            class="border border-black"
        />

        <flux:input
            wire:model="password"
            :label="__('Hasło')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="******"
            class="border border-black"
        />

        <flux:input
            wire:model="password_confirmation"
            :label="__('Powtórz hasło')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="******"
            class="border border-black"
        />

        <flux:button type="submit" variant="primary" class="w-full px-4 py-2 mt-4 rounded text-white font-medium hover:opacity-90 transition" style="background-color: #1fa37a;">
            {{ __('Zarejestruj się') }}
        </flux:button>
    </form>

    <div class="text-center text-sm text-zinc-600 dark:text-zinc-400 mt-6">
        Masz już konto?
        <flux:link :href="route('login')" wire:navigate>Zaloguj się</flux:link>
    </div>
</div>
