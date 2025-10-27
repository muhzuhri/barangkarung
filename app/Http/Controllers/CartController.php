<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        
        return view('keranjang', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
            'size' => 'string|in:S,M,L,XL,XXL'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        $size = $request->size ?? 'M';
        $userId = Auth::id();

        // Cek apakah produk dengan ukuran yang sama sudah ada di keranjang
        $existingCart = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('size', $size)
            ->first();

        if ($existingCart) {
            // Update quantity jika sudah ada
            $existingCart->quantity += $quantity;
            $existingCart->save();
        } else {
            // Tambah item baru ke keranjang
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'size' => $size
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'Quantity berhasil diupdate'
        ]);
    }

    public function remove($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang'
        ]);
    }

    public function clearAll()
    {
        $deletedCount = Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => "Semua item ($deletedCount item) berhasil dihapus dari keranjang"
        ]);
    }
}
