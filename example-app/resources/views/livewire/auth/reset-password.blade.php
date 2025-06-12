<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        Session::flash('status', __($status));

        // Zmienione z `redirectRoute('login')` na konkretną stronę
        $this->redirect('/restaurant', navigate: true);
    }
    public function messages(): array
    {
        return [
            'passwords.user' => 'Nie znaleziono użytkownika o podanym adresie e-mail.',
            'token.required' => 'Brakuje tokenu resetującego.',
            'email.required' => 'Podaj adres e-mail.',
            'email.email' => 'Wpisz poprawny adres e-mail.',
            'password.required' => 'Podaj nowe hasło.',
            'password.confirmed' => 'Hasła nie są takie same.',
            'passwords.token' => 'Ten link do resetowania hasła jest nieprawidłowy lub wygasł.',
        ];
    }

};
?>

<div class="bg-white p-8 rounded-lg shadow-md flex flex-col gap-6">
    <x-auth-header :title="__('Resetuj hasło')" :description="__('Wprowadź nowe hasło i potwierdź')" />

    <x-auth-session-status class="text-center text-sm text-green-600" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- Email -->
        <flux:input
            wire:model="email"
            :label="__('Adres e-mail')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
            class="!text-gray-900 mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 text-base shadow-sm focus:bg-white transition"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Nowe hasło')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="********"
            viewable
            class="!text-gray-900 mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 text-base shadow-sm focus:bg-white transition"
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Powtórz hasło')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="********"
            viewable
            class="!text-gray-900 mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 text-base shadow-sm focus:bg-white transition"
        />

        <flux:button variant="primary" type="submit" class="w-full px-4 py-2 rounded text-white font-medium hover:opacity-90 transition" style="background-color: #1fa37a;">
            {{ __('Zresetuj hasło') }}
        </flux:button>
    </form>

    <div class="text-center text-sm text-zinc-600 mt-4">
        {{ __('Masz już hasło?') }}
        <flux:link :href="route('login')" wire:navigate class="text-[#1fa37a] hover:underline">
            {{ __('Zaloguj się') }}
        </flux:link>
    </div>
</div>
