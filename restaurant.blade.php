<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | FoodiePlatform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-gray-50 font-sans antialiased">

    @include('components.header')

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
    
            <div class="bg-white rounded-xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl animate__animated animate__fadeInUp">
               
                <div class="relative h-80 md:h-96 bg-gradient-to-r from-green-800 to-green-900 flex items-center justify-center overflow-hidden">
            
                    <h1 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                        {{ $restaurant->name }}
                    </h1>
                    
                </div>
                
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-6 rounded-xl transition-all duration-300 hover:bg-white hover:shadow-md border border-gray-100">
                            <div class="flex items-start">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Adres</h3>
                                    <p class="text-gray-600">{{ $restaurant->address }}</p>
                                  
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-xl transition-all duration-300 hover:bg-white hover:shadow-md border border-gray-100">
                            <div class="flex items-start">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Telefon</h3>
                                    <p class="text-gray-600">{{ $restaurant->phone }}</p>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-8 bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Godziny otwarcia
                        </h3>
                    
                        @if($restaurant->is_active)
                            <div class="mb-4">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 animate__animated animate__pulse animate__infinite">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Restauracja jest otwarta! (8:00 - 22:00)
                                </span>
                            </div>
                        @else
                            <div class="mb-4">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    Restauracja jest zamknięta (otwarcie o 8:00)
                                </span>
                            </div>
                        @endif

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-700">Poniedziałek - Piątek</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">8:00 - 22:00</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-700">Sobota</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">9:00 - 23:00</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-700">Niedziela</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">10:00 - 21:00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>

    @include('components.footer')

</body>
</html>