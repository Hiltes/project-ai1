<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\User;

class Profile extends Component
{
    public string $name = '';
    public string $email = '';
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $city = null;
    public ?string $postal_code = null;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->city = $user->city;
        $this->postal_code = $user->postal_code;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
        ]);

        $user->update($validated);

        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.settings.profile')->layout('components.layouts.app', [
            'title' => 'Ustawienia profilu'
        ]);
    }
}

