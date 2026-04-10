<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @if(session('success'))
    <div id="toast" class="fixed bottom-5 right-5 bg-green-600 text-white px-6 py-3 rounded-2xl shadow-2xl transition-all duration-500 transform translate-y-0">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('toast').classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    </script>
    @endif

    <script>
        // Cari elemen alert
        const successAlert = document.getElementById('alert-success');
        const errorAlert = document.getElementById('alert-error');

        // Jika ada, hilangkan setelah 3 detik
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 3000);
        }

        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.display = 'none';
            }, 3000);
        }
    </script>

</body>

</html>