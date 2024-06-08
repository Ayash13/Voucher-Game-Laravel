@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Favorite Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @foreach ($favorites as $favorite)
                        <div
                            class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform transition-transform hover:scale-105 cursor-pointer">
                            <img src="{{ $favorite->product->image_url }}" alt="{{ $favorite->product->name }}"
                                class="w-full object-cover">
                            <div class="p-4">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $favorite->product->name }}
                                </h2>
                                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $favorite->product->description }}</p>
                                <p class="mt-2 font-bold text-gray-900 dark:text-white">Rp
                                    {{ number_format($favorite->product->price / 1000, 3, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
