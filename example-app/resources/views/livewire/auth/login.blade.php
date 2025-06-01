<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>

<div class="bg-white p-8 rounded-lg shadow-md flex flex-col gap-6">
    <x-auth-header :title="__('Zaloguj się')" :description="__('Wprowadź dane logowania')" />

    <x-auth-session-status class="text-center text-sm text-green-600" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email -->
        <flux:input
            wire:model="email"
            :label="__('Adres e-mail')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Hasło')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Hasło')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm text-blue-600 hover:underline" :href="route('password.request')" wire:navigate>
                    {{ __('Nie pamiętasz hasła?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Zapamiętaj mnie')" />

        <flux:button variant="primary" type="submit" class="w-full">
            {{ __('Zaloguj się') }}
        </flux:button>
    </form>

    @if (Route::has('register'))
        <div class="text-center text-sm text-zinc-600 mt-4">
            {{ __('Nie masz konta?') }}
            <flux:link :href="route('register')" wire:navigate class="text-[#1fa37a] hover:underline">
                {{ __('Zarejestruj się') }}
            </flux:link>
        </div>
    @endif
</div>
