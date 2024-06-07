<x-app-layout>
    <div class="container mx-auto">
        <div class="bg-gray-800 p-4 rounded">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-4">
            <h2 class="text-xl font-bold">{{ $product->name }}</h2>
            <p class="mb-4">{{ $product->description }}</p>
            <p class="text-lg font-bold mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            @if (auth()->check())
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Order</button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
