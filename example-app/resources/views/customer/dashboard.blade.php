<!DOCTYPE html>
<html lang="pl" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Panel użytkownika - FoodiePlatform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans flex flex-col min-h-screen">

    @include('components.header')

    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Panel użytkownika
            </h2>
            <p class="text-gray-700 text-lg">
                Witaj, {{ auth()->user()->name }}! Oto twój panel użytkownika
            </p>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-6 text-left">
            <h3 class="text-2xl font-bold mb-6">Zarządzanie</h3>
            <ul class="space-y-4">
                <li><a href="#" class="text-[#1fa37a] font-medium hover:underline">Restauracje</a></li>
                <li><a href="#" class="text-[#1fa37a] font-medium hover:underline">Twoje zamówienia</a></li>
            </ul>
        </section>
    </main>

    @include('components.footer')

</body>
</html>
