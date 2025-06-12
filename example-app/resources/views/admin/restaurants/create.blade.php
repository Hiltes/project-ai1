<x-layouts.app :title="'Dodaj Restaurację'">
    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Dodaj nową restaurację
            </h2>
        </section>

        <form method="POST" action="{{ route('admin.restaurants.store') }}" 
              class="bg-white shadow-md rounded-2xl p-8 space-y-6 max-w-2xl mx-auto"
              id="restaurantForm">
            @csrf
            @method('POST')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-800">Nazwa restauracji *</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                       class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                              focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-800">Opis</label>
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                 focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-800">Adres *</label>
                <input id="address" name="address" type="text" value="{{ old('address') }}" required
                       class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                              focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
            </div>

            <div>
    <label for="phone" class="block text-sm font-medium text-gray-800">Telefon *</label>
    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required
           pattern="\d{9}" minlength="9" maxlength="9" title="Wprowadź dokładnie 9 cyfr"
           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                  focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
</div>


            <div>
                <label for="delivery_fee" class="block text-sm font-medium text-gray-800">Opłata za dostawę (zł)</label>
                <input id="delivery_fee" name="delivery_fee" type="number" step="0.01" min="0"
                       value="{{ old('delivery_fee', 0) }}"
                       class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                              focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-gray-800">Typ kuchni *</label>
                <select id="type" name="type" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                               focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                    <option value="">-- Wybierz typ kuchni --</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" @if(old('type') == $type) selected @endif>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center">
                <input id="is_active" name="is_active" type="checkbox" value="1" class="mr-2"
                       @if(old('is_active', true)) checked @endif>
                <label for="is_active" class="text-sm text-gray-800">Restauracja aktywna</label>
            </div>

            <div class="text-center">
                <button type="submit"
                        class="bg-[#1fa37a] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#178a66] transition duration-200 shadow-md">
                    Dodaj restaurację
                </button>
            </div>
        </form>
    </main>
</x-layouts.app>