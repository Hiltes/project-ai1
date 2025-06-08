<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use OTPHP\TOTP;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|digits:6')]
    public string $code = '';

    public function verify(): void
    {
        $id = session('totp:id');
        if (! $id) {
            abort(403, 'Brak autoryzacji.');
        }

        $user = User::find($id);
        if (! $user || ! $user->totp_secret) {
            abort(403, 'Nieprawidłowe dane logowania.');
        }

        $totp = TOTP::create($user->totp_secret);

        if (! $totp->verify($this->code)) {
            throw ValidationException::withMessages([
                'code' => 'Nieprawidłowy kod TOTP.',
            ]);
        }

        // Zaloguj użytkownika i wyczyść sesję tymczasową
        Session::forget('totp:id');
        Auth::login($user);
        Session::regenerate();

        $this->redirect(route('home'), navigate: true);
    }
}; ?>

<div class="bg-white p-8 rounded-lg shadow-md flex flex-col gap-6">
    <x-auth-header :title="'Weryfikacja dwuetapowa'" :description="'Wprowadź 6-cyfrowy kod z aplikacji'" />

    <form wire:submit="verify" class="flex flex-col gap-6">
        <flux:input
            wire:model="code"
            label="Kod TOTP"
            type="text"
            required
            placeholder="123456"
            autofocus
            class="border border-black"
        />

        <flux:button variant="primary" type="submit" class="w-full px-4 py-2 rounded text-white font-medium hover:opacity-90 transition" style="background-color: #1fa37a;">
            Zweryfikuj
        </flux:button>
    </form>

    <div class="text-center text-sm text-zinc-600 mt-4">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Powrót do logowania</a>
    </div>
</div>
