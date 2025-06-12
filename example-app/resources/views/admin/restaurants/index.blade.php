<x-layouts.app :title="'Lista Restauracji'">
    <main class="flex-grow">
        <div class="bg-white shadow sm:rounded-2xl overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="sm:flex sm:items-center sm:justify-between mb-8">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-3xl font-bold text-emerald-700">Zarządzanie restauracjami</h1>
                        <p class="mt-2 text-sm text-gray-600">Lista wszystkich dostępnych restauracji w systemie</p>
                    </div>
                    <a href="{{ route('admin.restaurants.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Dodaj nową restaurację
                    </a>
                </div>

                <div class="bg-white shadow overflow-hidden sm:rounded-2xl">
                    @forelse($restaurants as $restaurant)
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center border-b border-gray-100 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="col-span-6">
                                <a href="{{ route('admin.restaurants.show', $restaurant) }}" class="text-lg font-semibold text-emerald-700 hover:text-emerald-900 hover:underline">
                                    {{ $restaurant->name }}
                                </a>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $restaurant->address ?? 'Brak adresu' }}
                                </p>
                            </div>
                            
                            <div class="col-span-6 flex justify-end space-x-2">
                                <a href="{{ route('admin.restaurants.edit', $restaurant) }}"
                                    class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition duration-200">
                                    Edytuj
                                </a>
                                <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Czy na pewno chcesz usunąć tę restaurację?')"
                                        class="inline-flex items-center px-4 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700 transition duration-200">
                                        Usuń
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak restauracji</h3>
                            <p class="mt-1 text-sm text-gray-500">Nie dodano jeszcze żadnych restauracji do systemu.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.restaurants.create') }}"
                                    class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition duration-200">
                                    Dodaj nową restaurację
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if (session('success'))
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-xl shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-6 py-3 rounded-xl shadow-lg z-50">
        {{ session('error') }}
    </div>
@endif
<script>
    setTimeout(() => {
        document.querySelectorAll('[class*="fixed top-4 left-1/2"]').forEach(el => {
            el.style.transition = 'opacity 0.5s ease-out';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 3000);
</script>

    </main>
</x-layouts.app>