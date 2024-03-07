<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order; // Tambahkan ini untuk mengimpor namespace Order

class PosController extends Controller
{
    public function index()
    {
        // Ambil data item keranjang dari database
        $cart_items = CartItem::all();

        // Ambil data produk untuk ditampilkan pada halaman pos
        $products = Product::all();

        $products = Product::paginate(10);
        $cart_items = DB::table('cart_items')->get();
        $cart_items = DB::table('cart_items')->paginate(10);

        // Kirim data item keranjang dan produk ke view
        return view('pos', compact('cart_items', 'products'));
    }

    public function destroy(Product $cart_items)
    {
        $cart_items->delete();
        return redirect()->route('pos');
    }

    // Method untuk menangani penyimpanan data dari permintaan POST
    public function store(Request $request)
{
    // Validasi permintaan
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'nama' => 'required|exists:products,nama',
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

    $cart_items = CartItem::all();

        // Ambil data produk untuk ditampilkan pada halaman pos
        $products = Product::all();
    // Mengembalikan respons yang sesuai
    return view('pos', compact('cart_items', 'products'));
}   
}
