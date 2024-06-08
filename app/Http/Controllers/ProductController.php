<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $favorites = [];
        if (Auth::check()) {
            $favorites = Favorite::where('id_user', Auth::id())->pluck('id_product')->toArray();
        }

        return view('welcome', compact('products', 'favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric',
            'image_url' => 'required|url|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Check for existing product with the same name to prevent duplication
                if (Product::where('name', $request->name)->exists()) {
                    throw new \Exception('Product already exists.');
                }

                Product::create($request->all());
            });

            return response()->json(['message' => 'Product added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409); // 409 Conflict
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric',
            'image_url' => 'required|url|max:255',
        ]);

        try {
            $product->update($request->all());
            return response()->json(['message' => 'Product updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update product.'], 500);
        }
    }
}
