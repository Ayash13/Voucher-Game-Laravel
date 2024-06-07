@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-4xl font-bold mb-8">Products</h1>
        @if (auth()->user()->is_admin)
            <a href="{{ route('products.create') }}"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Add
                Product</a>
        @endif
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="text-left py-3 px-4">Name</th>
                    <th class="text-left py-3 px-4">Description</th>
                    <th class="text-left py-3 px-4">Price</th>
                    <th class="text-left py-3 px-4">Image</th>
                    @if (auth()->user()->is_admin)
                        <th class="text-left py-3 px-4">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="text-left py-3 px-4">{{ $product->name }}</td>
                        <td class="text-left py-3 px-4">{{ $product->description }}</td>
                        <td class="text-left py-3 px-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="text-left py-3 px-4"><img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="h-16 w-16 object-cover"></td>
                        @if (auth()->user()->is_admin)
                            <td class="text-left py-3 px-4">
                                <a href="{{ route('products.edit', ['product' => $product->id_product]) }}"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                                <form action="{{ route('products.destroy', ['product' => $product->id_product]) }}"
                                    method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
