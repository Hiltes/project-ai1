<x-layouts.app :title="'Dodaj Danie'">
    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Panel administratora
            </h2>
            <p class="text-gray-700 text-lg">
                Witaj, {{ auth()->user()->name }}! Masz dostęp do zarządzania platformą.
            </p>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-6 text-left">
            <form method="POST" action="{{ route('admin.menu_items.store') }}"
                  enctype="multipart/form-data"
                  class="bg-white shadow-md rounded-2xl p-8 space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800">Nazwa dania</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                  focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                    @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800">Opis</label>
                    <textarea id="description" name="description" rows="4"
                              class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                     focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-800">Cena (zł)</label>
                    <input id="price" name="price" type="number" step="0.01" value="{{ old('price') }}" required
                           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                  focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                    @error('price')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="restaurant_id" class="block text-sm font-medium text-gray-800">Restauracja</label>
                    <select id="restaurant_id" name="restaurant_id" required
                            class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                   focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                        <option value="">-- wybierz restaurację --</option>
                        @foreach($restaurants as $rest)
                            <option value="{{ $rest->id }}" {{ old('restaurant_id') == $rest->id ? 'selected' : '' }}>
                                {{ $rest->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('restaurant_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-800">Kategoria</label>
                    <select id="category" name="category" required
                            class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                   focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                        <option value="">-- wybierz kategorię --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-800">Obrazek (500×500px, JPG)</label>
                    <input id="image" name="image" type="file" accept="image/jpeg"
                           class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm
                                  focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                    @error('image')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
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
