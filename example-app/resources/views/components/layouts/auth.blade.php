<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'FoodiePlatform' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans flex flex-col min-h-screen">

    @include('components.header')

    <main class="flex-grow flex justify-center px-4 pt-12 pb-6">
        <div class="w-full sm:max-w-md">
            {{ $slot }}
        </div>
    </main>

    @include('components.footer')

</body>
</html>
