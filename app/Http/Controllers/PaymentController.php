<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_product' => 'required|exists:products,id_product',
            'custom_amount' => 'required|numeric|min:1',
            'user_id' => 'required|string',
            'payment_method' => 'required|string',
            'whatsapp' => 'required|string',
        ]);

        try {
            $timestamp = now()->startOfSecond();

            // Create payment record
            $payment = Payment::create([
                'id_user' => Auth::id(),
                'id_product' => $request->id_product,
                'method' => $request->payment_method,
                'total' => $request->custom_amount * Product::find($request->id_product)->price,
                'whatsapp' => $request->whatsapp,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            // Check for existing history entry
            $existingHistory = History::where('id_user', Auth::id())
                ->where('id_product', $request->id_product)
                ->whereBetween('created_at', [$timestamp->subSecond(), $timestamp->addSecond()])
                ->first();

            if (!$existingHistory) {
                // Create history record
                History::create([
                    'id_pembayaran' => $payment->id_pembayaran,
                    'id_user' => Auth::id(),
                    'id_product' => $request->id_product,
                    'amount' => $request->custom_amount,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }

            return response()->json(['message' => 'Order processed successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to process order.'], 500);
        }
    }
}
