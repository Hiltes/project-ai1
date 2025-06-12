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

        $user = \App\Models\User::where('email', $this->email)->first();

        if (! $user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Nie znaleziono użytkownika o podanym adresie e-mail.',
            ]);
        }

        if (! \Illuminate\Support\Facades\Hash::check($this->password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'password' => 'Nieprawidłowe hasło.',
            ]);
        }

        Auth::login($user, $this->remember);
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $user = Auth::user();

        // Jeśli TOTP jest włączony, przekieruj do ekranu weryfikacji
        if ($user->totp_enabled) {
            session(['totp:id' => $user->id]); // zapisz ID, ale nie zalogowuj całkowicie
            Auth::logout(); // wyloguj tymczasowo do momentu podania kodu

            $this->redirect(route('totp.verify'), navigate: true);
            return;
        }

        // Brak TOTP – normalny redirect
        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
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

    public function messages(): array
    {
        return [
            'email.required' => 'Podaj adres e-mail.',
            'email.email' => 'Wpisz poprawny adres e-mail.',
            'password.required' => 'Podaj hasło.',
        ];
    }
}; ?>

<div class="bg-white p-8 rounded-lg shadow-md flex flex-col gap-6">
    <x-auth-header :title="__('Zaloguj się')" :description="__('Wprowadź dane logowania')" />

    <x-auth-session-status class="text-center text-sm text-green-600" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-4">
        <!-- Email -->
        <flux:input
            wire:model="email"
            :label="__('Adres e-mail')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
            class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 text-base shadow-sm focus:bg-white transition"
        />
        <!-- Password -->
        <div class="relative ">
            <flux:input
                wire:model="password"
                :label="__('Hasło')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Hasło')"
                viewable
                class="!text-gray-900 mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 text-base shadow-sm focus:bg-white transition"
            />
        </div>

        <flux:button variant="primary" type="submit" class="w-full px-4 py-2 mt-6 rounded text-white font-medium hover:opacity-90 transition" style="background-color: #1fa37a;">
            {{ __('Zaloguj się') }}
        </flux:button>
    </form>

    @if (Route::has('register'))
        <div class="text-center text-sm text-zinc-700 mt-4">
            {{ __('Nie masz konta?') }}
            <flux:link :href="route('register')" wire:navigate class="text-[#1fa37a] hover:underline">
                {{ __('Zarejestruj się') }}
            </flux:link>
        </div>
    @endif
</div>
