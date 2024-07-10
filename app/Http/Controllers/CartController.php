<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function index(): JsonResponse
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        return response()->json($cart);
    }

    public function destroy($id): JsonResponse
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);

        // Delete all related cart items
        $cart->items()->delete();

        // Delete the cart itself
        $cart->delete();

        return response()->json(['message' => 'Cart deleted successfully'], 200);
    }
}
