<x-layouts.app>
    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Wystaw opinię o restauracji</h1>

        @if($restaurantsToReview->isEmpty())
            <p class="text-gray-600">Nie masz żadnych restauracji do oceny.</p>
        @else
            @foreach($restaurantsToReview as $restaurant)
                <div class="bg-white shadow rounded-2xl p-6 mb-6">
                    <h2 class="text-xl font-semibold">{{ $restaurant->name }}</h2>

                    <form method="POST" action="{{ route('reviews.restaurants.store') }}" class="mt-4 space-y-4">
                        @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                        <div>
                            <label for="rating-{{ $restaurant->id }}" class="block font-medium">Ocena (1-5):</label>
                            <select name="rating" id="rating-{{ $restaurant->id }}" required class="w-full border rounded p-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="comment-{{ $restaurant->id }}" class="block font-medium">Komentarz (opcjonalnie):</label>
                            <textarea name="comment" id="comment-{{ $restaurant->id }}" rows="3" class="w-full border rounded p-2"></textarea>
                        </div>

                        <button type="submit" class="bg-[#1fa37a] text-white px-4 py-2 rounded-xl shadow hover:bg-[#178f6b] transition">
                            Wyślij opinię
                        </button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
</x-layouts.app>
