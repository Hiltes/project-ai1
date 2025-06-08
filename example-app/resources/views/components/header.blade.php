<header class="w-full px-6 py-4 shadow-md" style="background-color: #ffc244;">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold text-black">🍽️ FoodiePlatform</h1>
        <nav class="flex items-center space-x-4">
            <a href="{{ url('/') }}" class="text-black hover:underline">Strona główna</a>
            <a href="{{ route('items.ranking') }}" class="text-black hover:underline">Ranking dań</a>
            <a href="{{ route('items.index') }}" class="text-black hover:underline">Wyszukiwarka potraw</a>
            <a href="{{ route('restaurants.index') }}" class="text-black hover:underline">Wyszukiwarka restauracji</a>
            
            
            @auth
            <a href="{{ route('user.panel') }}" class="text-black hover:underline">Panel użytkownika</a>
            <a href="{{ route('cart.show') }}" class="text-black hover:underline">Koszyk</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded text-white font-medium hover:opacity-90 transition"
                        style="background-color: #1fa37a;">
                        Wyloguj się
                    </button>
                </form>
            @endauth

            @guest
                <a class="px-4 py-2 rounded text-white font-medium hover:opacity-90 transition"
                    style="background-color: #1fa37a;" href="{{ route('login') }}">
                    Zaloguj się
                </a>
            @endguest
        </nav>
    </div>
</header>
