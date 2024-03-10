<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order; // Tambahkan ini untuk mengimpor namespace Order

class PosController extends Controller
{
    public function index()
    {
        // Ambil data item keranjang dari database
        $cart_items = CartItem::all();

        $orders = Order::all();

        // Ambil data produk untuk ditampilkan pada halaman pos
        $products = Product::all();

        $products = Product::paginate(10);
        $cart_items = DB::table('cart_items')->get();
        $cart_items = CartItem::paginate(10);

        // Hitung total harga dari semua item
        $totalPrice = DB::table('cart_items')->sum(DB::raw('harga * quantity'));

        $totalPrice = 0;
        foreach ($cart_items as $cart_item) {
            $totalPrice += $cart_item->harga * $cart_item->quantity;
        }

        // Kirim data item keranjang dan produk ke view
        return view('pos', compact('cart_items', 'products','totalPrice'));
    }

    public function destroy(CartItem $cart_item)
    {
        $cart_item->delete(); // Hapus item keranjang dari database
        return redirect()->route('pos'); // Redirect kembali ke halaman pos
    }

public function store(Request $request)
{
    // Validasi permintaan
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|numeric|min:1',
    ]);

    // Ambil data produk berdasarkan ID
    $product = Product::findOrFail($request->product_id);

    // Membuat atau memperbarui item keranjang
    $cartItem = CartItem::updateOrCreate(
        ['product_id' => $request->product_id],
        [
            'quantity' => $request->quantity,
            'nama' => $product->nama, // Menggunakan nama produk sebagai nilai untuk kolom 'nama'
            'harga' => $product->harga // Menggunakan harga produk sebagai nilai untuk kolom 'harga'
        ]
    );

    // Menyimpan item keranjang
    $cartItem->save();

    // Mengembalikan respons yang sesuai
    return redirect()->route('pos');
}

public function confirmOrder(Request $request)
    {
        $cartItems = $request->input('cart_items');

        if (is_array($cartItems) || is_object($cartItems)) {
            foreach ($cartItems as $cartItem) {
                $order = new Order();
                $order->product_id = $cartItem['product_id'];
                $order->quantity = $cartItem['quantity'];
                $order->nama = $cartItem['nama'];
                $order->harga = $cartItem['harga'];
                $order->save();
            }

            return response()->json(['message' => 'Order confirmed successfully'], 200);
        } else {
            return response()->json(['message' => 'No cart items received'], 400);
        }
    }
}
