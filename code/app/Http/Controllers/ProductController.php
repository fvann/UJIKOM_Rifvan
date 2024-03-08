<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric', // Ensure harga is numeric
        ]);

        Product::create($validatedData);
        return redirect()->route('products.index');
    }

    public function edit($id)
{
    $product = Product::find($id);
    return view('products.edit', compact('product'));
}

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }

    public function update(Request $request, Product $product)
    {
    $request->validate([
        'nama' => 'required',
        'harga' => 'required',
    ]);

    $product->update([
        'nama' => $request->nama,
        'harga' => $request->harga,
    ]);

    return redirect()->route('products.index');
}

}