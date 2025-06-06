<x-layouts.app>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-accent">Edytuj dane użytkownika</h1>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6 bg-white p-6 rounded shadow">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Imię i nazwisko</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                       class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-accent focus:border-accent sm:text-sm" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adres e-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                       class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-accent focus:border-accent sm:text-sm" />
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Numer telefonu</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}"
                       class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-accent focus:border-accent sm:text-sm" />
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Adres</label>
                <input type="text" name="address" id="address" value="{{ old('address', auth()->user()->address) }}"
                       class="px-4 py-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-accent focus:border-accent sm:text-sm" />
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-2 bg-accent text-white rounded hover:bg-green-700 transition">Zapisz zmiany</button>
            </div>
        </form>
    </div>
</x-layouts.app>
