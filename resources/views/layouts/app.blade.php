<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between">
            <div>
                <a href="{{ url('/') }}" class="text-2xl font-bold">Beli Voucher Game</a>
            </div>
            <div class="flex space-x-4">
                <a href="{{ url('/') }}" class="text-gray-200">Home</a>
                <a href="{{ route('profile.edit') }}" class="text-gray-200">Profile</a>
                @auth
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.history') }}" class="text-gray-200">Admin History</a>
                    @else
                        <a href="{{ route('history') }}" class="text-gray-200">History</a>
                        <a href="{{ route('favorites.index') }}" class="text-gray-200">Favorites</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-200">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-200">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-200">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    <main class="py-8">
        @yield('content')
    </main>
    @vite('resources/js/app.js')
</body>

</html>
