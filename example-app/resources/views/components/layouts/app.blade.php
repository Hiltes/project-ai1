{{-- resources/views/components/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pl" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'FoodiePlatform' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body class="bg-gray-100 text-gray-900 font-sans flex flex-col min-h-screen">

    @include('components.header')

    <main class="flex-grow">
        {{ $slot }}
    </main>

    @include('components.footer')

    @livewireScripts
</body>
</html>
