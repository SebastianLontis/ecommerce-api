<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartController extends Controller
{
    public function index(): JsonResponse
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json($cart);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $cart = Cart::where('user_id', Auth::id())->findOrFail($id);

            $cart->items()->delete();

            $cart->delete();

            return response()->json(['message' => 'Cart deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cart not found'], 404);
        }
    }
}
