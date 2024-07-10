<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CartItemController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = $cart->items()->updateOrCreate(
            ['product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json($cartItem, 201);
    }

    public function update(Request $request, $itemId): JsonResponse
    {
        $cartItem = CartItem::where('cart_id', Auth::user()->cart->id)->findOrFail($itemId);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json($cartItem);
    }

    public function destroy($itemId): JsonResponse
    {
        $cartItem = CartItem::where('cart_id', Auth::user()->cart->id)->findOrFail($itemId);
        $cartItem->delete();

        return response()->json(null, 204);
    }
}
