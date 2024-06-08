@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" x-data="productManagement()">
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div id="product-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach ($products as $product)
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform transition-transform hover:scale-105 cursor-pointer">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full object-cover"
                            @click="showDetailModal = true; selectedProduct = {{ $product->toJson() }}">
                        @auth
                            @if (auth()->user()->is_admin)
                                <div class="absolute top-2 right-2 flex space-x-2">
                                    <button @click.stop="showEditModal = true; selectedProduct = {{ $product->toJson() }}"
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white rounded-full p-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click.stop="deleteProduct({{ $product->id_product }})"
                                        class="bg-red-500 hover:bg-red-700 text-white rounded-full p-2">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        @endauth
                        <div class="p-4">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center justify-between">
                                {{ $product->name }}
                                <button @click.stop="toggleFavorite({{ $product->id_product }})" class="text-red-500 ml-2">
                                    <i
                                        :class="isFavorite({{ $product->id_product }}) ? 'fas fa-heart' : 'far fa-heart'"></i>
                                </button>
                            </h2>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $product->description }}</p>
                            <p class="mt-2 font-bold text-gray-900 dark:text-white">Rp
                                {{ number_format($product->price / 1000, 3, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Floating Add Button -->
        @auth
            @if (auth()->user()->is_admin)
                <button @click="showAddModal = true"
                    class="fixed bottom-8 right-8 bg-green-500 hover:bg-green-700 text-white font-bold py-5 px-5 rounded-full shadow-lg">
                    <i class="fas fa-plus"></i>
                </button>
            @endif
        @endauth

        <!-- Detail Modal -->
        <template x-if="showDetailModal">
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden w-3/4 max-w-4xl">
                    <div class="flex">
                        <img :src="selectedProduct ? selectedProduct.image_url : ''" alt=""
                            class="w-1/2 h-auto p-8 object-cover">
                        <div class="w-1/2 p-8">
                            <button @click="showDetailModal = false"
                                class="text-gray-700 dark:text-gray-300 float-right">&times;</button>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white"
                                x-text="selectedProduct ? selectedProduct.name : ''"></h2>
                            <p class="mt-2 text-gray-600 dark:text-gray-400"
                                x-text="selectedProduct ? selectedProduct.description : ''"></p>
                            <p class="mt-2 font-bold text-gray-900 dark:text-white">Rp <span
                                    x-text="formatPrice(selectedProduct.price)"></span></p>

                            <div class="mt-4">
                                <label for="custom_amount"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Custom Amount
                                    (CP)</label>
                                <input type="number" id="custom_amount" x-model="customAmount"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700">
                            </div>

                            <div class="mt-4">
                                <label for="user_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">User ID/Player
                                    ID</label>
                                <input type="text" id="user_id" x-model="userId"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700">
                            </div>

                            <div class="mt-4">
                                <label for="payment_method"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment
                                    Method</label>
                                <select id="payment_method" x-model="paymentMethod"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700">
                                    <option value="GOPAY">E-Wallet</option>
                                    <option value="QRIS">QRIS</option>
                                    <option value="Transfer BCA">Transfer BCA</option>
                                    <option value="Alfamart">Alfamart</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <label for="whatsapp"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Whatsapp
                                    Number</label>
                                <input type="text" id="whatsapp" x-model="whatsappNumber"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700">
                            </div>

                            <div class="mt-4">
                                <p class="font-bold text-gray-900 dark:text-white">Total Price: Rp <span
                                        x-text="totalPrice"></span></p>
                            </div>

                            @auth
                                <div class="mt-4">
                                    <button @click="processOrder"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Process
                                        Order</button>
                                </div>
                            @else
                                <div class="mt-4">
                                    <button @click="redirectToLogin"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login to
                                        Order</button>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Add Modal -->
        @auth
            @if (auth()->user()->is_admin)
                <template x-if="showAddModal">
                    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden w-1/2">
                            <div class="p-6">
                                <button @click="showAddModal = false"
                                    class="text-gray-700 dark:text-gray-300 float-right">&times;</button>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Add Product</h2>
                                <form @submit.prevent="addProduct" class="mt-4" id="add-product-form">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                        <input type="text" name="name" id="name" x-model="newProduct.name"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="description"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                        <textarea name="description" id="description" rows="3" x-model="newProduct.description"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700" required></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="price"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                                        <input type="number" name="price" id="price" x-model="newProduct.price"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="image_url"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image
                                            URL</label>
                                        <input type="text" name="image_url" id="image_url" x-model="newProduct.image_url"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700"
                                            required>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" :disabled="isLoading"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add
                                            Product</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </template>
            @endif
        @endauth

        <!-- Edit Modal -->
        <template x-if="showEditModal">
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden w-1/2">
                    <div class="p-6">
                        <button @click="showEditModal = false"
                            class="text-gray-700 dark:text-gray-300 float-right">&times;</button>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Product</h2>
                        <form @submit.prevent="editProduct" class="mt-4" id="edit-product-form">
                            @csrf
                            <input type="hidden" x-model="selectedProduct.id_product">
                            <div class="mb-4">
                                <label for="edit-name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <input type="text" id="edit-name" x-model="selectedProduct.name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="edit-description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea id="edit-description" x-model="selectedProduct.description" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="edit-price"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                                <input type="number" id="edit-price" x-model="selectedProduct.price"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="edit-image-url"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image URL</label>
                                <input type="text" id="edit-image-url" x-model="selectedProduct.image_url"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700"
                                    required>
                            </div>
                            <div class="mt-4">
                                <button type="submit" :disabled="isLoading"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Save
                                    Changes</button>
                            </div>
                            <div x-show="isLoading" class="text-center mt-4">
                                <span>Loading...</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productManagement', () => ({
            showModal: false,
            showAddModal: false,
            showEditModal: false,
            showDetailModal: false,
            isLoading: false,
            selectedProduct: null,
            customAmount: null,
            userId: '',
            paymentMethod: 'e_wallet',
            whatsappNumber: '',
            newProduct: {
                name: '',
                description: '',
                price: '',
                image_url: ''
            },
            products: @json($products),
            favorites: @json($favorites),
            isFavorite(productId) {
                return this.favorites.includes(productId);
            },
            async toggleFavorite(productId) {
                try {
                    const response = await fetch(`{{ route('favorites.toggle') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id_product: productId
                        })
                    });
                    if (response.ok) {
                        if (this.isFavorite(productId)) {
                            this.favorites = this.favorites.filter(id => id !== productId);
                        } else {
                            this.favorites.push(productId);
                        }
                    } else {}
                } catch (error) {}
            },
            get totalPrice() {
                if (this.customAmount) {
                    return (this.customAmount * this.selectedProduct.price / 1000).toFixed(3)
                        .replace('.', ',');
                }
                return (0).toFixed(3).replace('.', ',');
            },
            formatPrice(price) {
                return (price / 1000).toFixed(3).replace('.', ',');
            },
            redirectToLogin() {
                window.location.href = '{{ route('login') }}';
            },
            async deleteProduct(id) {
                try {
                    const response = await fetch(`{{ url('products') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    if (response.ok) {
                        this.products = this.products.filter(product => product.id_product !==
                            id);
                        this.showModal = false;
                        location.reload();
                    } else {}
                } catch (error) {}
            },
            async addProduct() {
                this.isLoading = true;
                try {
                    const response = await fetch(`{{ route('products.store') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.newProduct)
                    });
                    if (!response.ok) {
                        const responseData = await response.json();
                        throw new Error(responseData.message || 'Failed to add the product.');
                    }

                    // Clear the form
                    this.newProduct.name = '';
                    this.newProduct.description = '';
                    this.newProduct.price = '';
                    this.newProduct.image_url = '';

                    // Close the modal
                    this.showAddModal = false;

                    // Refresh the page
                    setTimeout(() => location.reload(), 100);
                } catch (error) {} finally {
                    this.isLoading = false;
                }
            },
            async editProduct() {
                this.isLoading = true;
                try {
                    const response = await fetch(
                        `{{ url('products') }}/${this.selectedProduct.id_product}`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(this.selectedProduct)
                        });

                    if (!response.ok) {
                        const responseData = await response.json();
                        throw new Error(responseData.message || 'Failed to edit the product.');
                    }

                    const updatedProduct = await response.json();

                    this.products = this.products.map(product =>
                        product.id_product === updatedProduct.id_product ? updatedProduct :
                        product
                    );

                    location.reload();
                } catch (error) {} finally {
                    this.isLoading = false;
                }
            },
            async processOrder() {
                this.isLoading = true;
                try {
                    const response = await fetch(`{{ route('payment.store') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id_product: this.selectedProduct.id_product,
                            custom_amount: this.customAmount,
                            user_id: this.userId,
                            payment_method: this.paymentMethod,
                            whatsapp: this.whatsappNumber,
                            price: this.selectedProduct.price
                        })
                    });
                    if (!response.ok) {
                        const responseData = await response.json();
                        throw new Error(responseData.message || 'Failed to process the order.');
                    }

                    this.showDetailModal = false;
                    location.reload();
                } catch (error) {} finally {
                    this.isLoading = false;
                }
            },
        }));
    });
</script>
