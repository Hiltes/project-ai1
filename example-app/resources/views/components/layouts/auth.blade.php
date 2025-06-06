<!DOCTYPE html>
<html lang="pl" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Logowanie - FoodiePlatform' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900 font-sans flex flex-col min-h-screen">

    <main class="flex flex-1 items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
</body>
</html>
