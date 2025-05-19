<div class="bg-white p-6 rounded-lg border border-gray-200 shadow hover:shadow-lg transition flex flex-col justify-between">
    <div>
        <h4 class="text-xl font-semibold text-black mb-2">{{ $restaurant['name'] }}</h4>
        <p class="text-gray-600 mb-4">{{ $restaurant['description'] }}</p>
    </div>
    <a href="/restaurant/{{ $restaurant['id'] }}"
       class="text-white px-4 py-2 rounded text-center font-medium hover:opacity-90 transition"
       style="background-color: #1fa37a;">
        Zobacz menu
    </a>
</div>
