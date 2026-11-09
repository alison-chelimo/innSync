<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hotel') | {{ config('app.name', 'Hotel') }}</title>
    {{-- Tailwind via CDN so this works with any starter kit. Swap for Vite later if you like. --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <nav class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600">{{ config('app.name', 'Hotel') }}</a>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('rooms.index') }}" class="hover:text-indigo-600">Rooms</a>
                @auth
                    @if (Route::has('dashboard'))
                        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">My dashboard</a>
                    @endif
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="hover:text-indigo-600">Log in</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="mb-6 rounded bg-green-100 text-green-800 px-4 py-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded bg-red-100 text-red-800 px-4 py-3">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-sm text-gray-500 py-8">
        &copy; {{ date('Y') }} {{ config('app.name', 'Hotel') }}
    </footer>
</body>
</html>
