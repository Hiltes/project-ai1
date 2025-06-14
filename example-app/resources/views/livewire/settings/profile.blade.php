<x-layouts.app :title="'Edytuj profil'">
    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Edytuj dane użytkownika
            </h2>
        </section>

        <section class="max-w-4xl mx-auto px-6 py-6 text-left">
            <form method="POST" action="{{ route('profile.update') }}"
                  class="bg-white shadow-md rounded-2xl p-8 space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800">Imię i nazwisko</label>
                    <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required
                           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-800">Adres e-mail</label>
                    <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required
                           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-800">Numer telefonu</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', auth()->user()->phone) }}"
                           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-800">Adres</label>
                    <input id="address" name="address" type="text" value="{{ old('address', auth()->user()->address) }}"
                           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <h3 class="text-xl font-semibold text-gray-800">Zmiana hasła</h3>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-800">Nowe hasło</label>
                    <input id="password" name="password" type="password"
                           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-800">Powtórz hasło</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div class="text-center">
                    <button type="submit"
                            class="bg-[#1fa37a] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#178a66] transition duration-200 shadow-md">
                        Zapisz zmiany
                    </button>
                </div>
            </form>
        </section>
    </main>
</x-layouts.app>
