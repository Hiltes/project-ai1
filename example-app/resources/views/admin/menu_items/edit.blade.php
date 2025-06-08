<x-layouts.app :title="'Edytuj Danie'">
    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Edycja dania
            </h2>
            <p class="text-gray-700 text-lg">
                Wprowadź zmiany w wybranym daniu: <strong>{{ $menuItem->name }}</strong>
            </p>
        </section>

        <form method="POST" action="{{ route('admin.menu_items.update', $menuItem) }}" enctype="multipart/form-data"
            class="bg-white shadow-md rounded-2xl p-8 space-y-6">


            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-800">Nazwa dania</label>
                <input id="name" name="name" type="text" value="{{ old('name', $menuItem->name) }}" required
                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                  focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-800">Opis</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                     focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">{{ old('description', $menuItem->description) }}</textarea>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-800">Cena (zł)</label>
                <input id="price" name="price" type="number" step="0.01"
                    value="{{ old('price', $menuItem->price) }}" required
                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                  focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
            </div>

            <div>
                <label for="restaurant_id" class="block text-sm font-medium text-gray-800">Restauracja</label>
                <select id="restaurant_id" name="restaurant_id" required
                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                   focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                    <option value="">-- wybierz restaurację --</option>
                    @foreach ($restaurants as $rest)
                        <option value="{{ $rest->id }}"
                            {{ old('restaurant_id', $menuItem->restaurant_id) == $rest->id ? 'selected' : '' }}>
                            {{ $rest->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-800">Kategoria</label>
                <select id="category" name="category" required
                    class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                   focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                    <option value="">-- wybierz kategorię --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}"
                            {{ old('category', $menuItem->category) == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-800">Zdjęcie (500x500 JPG)</label>

                @if ($menuItem->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $menuItem->image) }}" alt="Aktualne zdjęcie"
                            class="w-32 h-32 object-cover rounded-xl border border-gray-300">
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Pozostaw puste, jeśli nie chcesz zmieniać zdjęcia.</p>
                @endif

                <input type="file" id="image" name="image"
                    class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                  file:text-sm file:font-semibold file:bg-[#1fa37a] file:text-white hover:file:bg-[#178a66]">
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
