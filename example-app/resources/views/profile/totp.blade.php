<x-layouts.app :title="'Uwierzytelnianie dwuskładnikowe'">
    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Uwierzytelnianie dwuskładnikowe (TOTP)
            </h2>
        </section>

        <section class="max-w-4xl mx-auto px-6 py-6 text-left">
            <div class="bg-white shadow-md rounded-2xl p-8 space-y-6">

                @if (session('success'))
                    <div class="p-4 rounded-xl bg-green-100 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($user->totp_enabled)
                    <p class="text-gray-700 text-lg">
                        Uwierzytelnianie dwuskładnikowe jest <strong>włączone</strong> dla Twojego konta.
                    </p>

                    <form method="POST" action="{{ route('totp.disable') }}">
                        @csrf
                        <div class="mt-6 text-center">
                            <button type="submit"
                                    class="bg-red-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-red-700 transition duration-200 shadow-md">
                                Wyłącz TOTP
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center">
                        <div class="inline-block bg-white border rounded-xl p-4 shadow">
                            {!! $qrCode !!}
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Zeskanuj kod QR w aplikacji Google Authenticator lub podobnej.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('totp.enable') }}" class="space-y-4 mt-8">
                        @csrf

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-800">
                                Kod z aplikacji
                            </label>
                            <input id="code" name="code" type="text" required
                                   class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition"
                                   placeholder="123456">
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit"
                                    class="bg-[#1fa37a] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#178a66] transition duration-200 shadow-md">
                                Włącz TOTP
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </section>
    </main>
</x-layouts.app>
