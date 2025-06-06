<x-layouts.app :title="'Dodaj Użytkownika'">
    <main class="flex-grow">
        <section class="max-w-4xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Utwórz użytkownika
            </h2>
        </section>

        <section class="max-w-4xl mx-auto px-6 py-6 text-left">

            @if ($errors->any())
                <div class="mb-6 text-red-600">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}"
                class="bg-white shadow-md rounded-2xl p-8 space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800">Imię i nazwisko</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-800">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-800">Telefon</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-800">Adres</label>
                    <input id="address" name="address" type="text" value="{{ old('address') }}"
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-800">Rola</label>
                    <select id="role" name="role" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                        <option value="">Wybierz rolę</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-800">Hasło</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-800">Potwierdź hasło</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="bg-[#1fa37a] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#178a66] transition duration-200 shadow-md">
                        Zapisz
                    </button>
                </div>
            </form>
        </section>
    </main>
</x-layouts.app>
