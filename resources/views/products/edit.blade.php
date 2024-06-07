@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-4xl font-bold mb-8">Edit Product</h1>

        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ $product->name }}"
                    class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded">{{ $product->description }}</textarea>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Price</label>
                <input type="text" id="price" name="price" value="{{ $product->price }}"
                    class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="image_url" class="block text-gray-700">Image URL</label>
                <input type="text" id="image_url" name="image_url" value="{{ $product->image_url }}"
                    class="w-full p-2 border border-gray-300 rounded">
            </div>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
        </form>
    </div>
@endsection
