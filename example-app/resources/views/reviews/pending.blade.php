<x-layouts.app :title="'Twoje recenzje'">
    <main class="flex-grow">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-emerald-700 mb-8">Oceny do wystawienia</h1>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg shadow-sm">{{ session('error') }}</div>
            @endif

            @if ($itemsToReview->isEmpty())
                <p class="text-center text-gray-500 text-lg">Brak pozycji do oceny. Dziękujemy!</p>
            @else
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($itemsToReview as $item)
                        <div class="bg-white p-6 rounded-xl shadow text-center flex flex-col items-center">
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                    class="w-24 h-24 object-cover rounded-lg mb-4">
                            @else
                                <div
                                    class="w-24 h-24 bg-gray-100 flex items-center justify-center text-gray-400 rounded-lg mb-4">
                                    brak zdj.</div>
                            @endif

                            <h2 class="text-lg font-semibold text-gray-800">{{ $item->name }}</h2>
                            <p class="text-sm text-gray-500 mb-4">{{ number_format($item->price, 2) }} zł</p>

                            <form action="{{ route('reviews.store') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="menu_item_id" value="{{ $item->id }}">

                                <div class="flex justify-center mb-2 space-x-1 star-rating" data-selected="0">
                                    @for ($star = 1; $star <= 5; $star++)
                                        <svg data-value="{{ $star }}"
                                            class="w-6 h-6 text-gray-300 cursor-pointer transition" fill="currentColor"
                                            viewBox="0 0 20 20" aria-label="{{ $star }} gwiazdka">
                                            <polygon
                                                points="9.9,1.1,12.6,7.1,18.9,7.6,14,11.9,15.6,18.2,9.9,14.9,4.2,18.2,5.8,11.9,1,7.6,7.4,7.1" />
                                        </svg>
                                    @endfor
                                    <!-- ukryte pole wewnątrz .star-rating -->
                                    <input type="hidden" name="rating" value="0" class="rating-input">
                                </div>

                                @error('rating')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <button type="submit"
                                    class="w-full mt-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                                    Wyślij ocenę
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    <script>
        document.querySelectorAll('.star-rating').forEach(container => {
            const stars = container.querySelectorAll('svg');
            const input = container.querySelector('.rating-input');
            let selected = parseInt(input.value) || 0;

            function setStars(rating) {
                stars.forEach((star, i) => {
                    star.classList.toggle('text-amber-400', i < rating);
                    star.classList.toggle('text-gray-300', i >= rating);
                });
            }

            stars.forEach((star, index) => {
                star.addEventListener('mouseover', () => setStars(index + 1));
                star.addEventListener('mouseout', () => setStars(selected));
                star.addEventListener('click', () => {
                    selected = index + 1;
                    input.value = selected;
                    setStars(selected);
                });
            });
            setStars(selected);
        });
    </script>
</x-layouts.app>
