@extends('layout.mainlayout')

@section('content')
<div class="h-full ml-14 mt-14 mb-10 md:ml-64">
  <div class="container mx-auto flex flex-col md:flex-row">
    <!-- Product List -->
    <div class="md:w-3/4 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <!-- Product Card -->
            @foreach ($products as $product)
            <div class="bg-gray-100 rounded-lg shadow-md p-4">
                <h2 class="text-gray-500 text-lg font-bold mb-2">{{ $product->nama }}</h2>
                <p class="text-gray-500">Harga: Rp{{ $product->harga }}</p>
                <p class="text-gray-500">Stok : {{ $product->stok }}</p>
                <!-- Form untuk menambahkan produk ke keranjang belanja -->
                <form id="add-to-cart-form{{ $product->id }}" class="add-to-cart-form" method="POST">
                    @csrf
                    <input type="hidden" name="nama" value="{{ $product->nama }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="harga" value="{{ $product->harga }}">
                    <div class="flex items-center mt-2">
                        <label for="quantity{{ $product->id }}" class="text-gray-500 mr-2">Quantity:</label>
                        <input type="number" id="quantity{{ $product->id }}" name="quantity" value="1" min="1" required class="text-gray-500 border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:border-blue-500 w-16">
                    </div>
                    <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md inline-block">Add to Cart</button>
                </form>
            </div>            
            @endforeach
        </div>
    </div>

    <!-- Shopping Cart Sidebar -->
    <div class="md:w-1/4 bg-gray-800 rounded-lg shadow-md p-8 mr-5 mt-7 md:mt-15">
        <h2 class="text-xl font-bold mb-4 text-white">Shopping Cart</h2>
        <div id="cartItemsContainer">
            @foreach ($cart_items as $cart_item)
                <div class="bg-gray-100 rounded-lg shadow-md p-4 mt-5">
                    <p class="text-gray-700">{{ $cart_item->nama }} x {{ $cart_item->quantity }}</p>
                    <p class="text-gray-700">Rp{{ $cart_item->harga * $cart_item->quantity }}.00</p>
                    <form id="deleteForm{{ $cart_item->id }}" action="{{ route('delete.cart_item', ['cart_item' => $cart_item->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-red-700 bg-red-200 hover:bg-red-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Delete</button>
                    </form>                
                </div>
            @endforeach
        </div>
        <hr class="my-4">
        <div id="totalContainer" class="flex justify-between items-center">
            <span class="text-lg font-bold text-white">Total: </span>
            <!-- Menampilkan total harga -->
            <span id="totalPrice" class="text-lg font-bold text-white">Rp{{ $totalPrice }}.00</span>
        </div>
        <!-- Tombol checkout -->
        <button onclick="openModal()" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md">Checkout</button>
    </div>
    
</div>

<!-- Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h1 class="text-xl font-bold mb-4 text-gray-700 mt-4">Shopping Cart</h1>
        <form id="confirmOrderForm" action="{{ route('confirm.order') }}" method="POST">
            @csrf
        @foreach ($cart_items as $cart_item)
        <div class="flex justify-between">
            <p class="text-gray-700">{{ $cart_item->nama }} x {{ $cart_item->quantity }}</p>
            <p class="text-gray-700">Rp{{ $cart_item->harga * $cart_item->quantity }}.00</p>
        </div>
        <hr class="my-4">
        @endforeach
        <div id="totalContainer" class="flex justify-between items-center">
            <span class="text-lg font-bold text-gray-700">Total: </span>
            <!-- Menampilkan total harga -->
            <span id="totalPrice" class="text-lg font-bold text-gray-700">Rp{{ $totalPrice }}.00</span>
        </div>
        <div class="flex justify-between">
        <button onclick="printModal()" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md">Print</button>
            <input type="hidden" name="cart" value="{{ json_encode($cart_items) }}">
            <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md">Konfirmasi</button>
        </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let cart = [];

    document.addEventListener('DOMContentLoaded', function() {
        const addToCartForms = document.querySelectorAll('.add-to-cart-form');
        addToCartForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const productId = this.querySelector('input[name="product_id"]').value;
                const quantity = parseInt(this.querySelector('input[name="quantity"]').value);
                const product = {
                    id: productId,
                    quantity: quantity,
                    nama: this.querySelector('input[name="nama"]').value,
                    harga: parseFloat(this.querySelector('input[name="harga"]').value)
                };
                addToCart(product);
                updateCart(); // Perbarui daftar item dalam keranjang belanja setelah menambahkan item
            });
        });
    });

    function addToCart(product) {
        var existingItem = cart.find(item => item.id === product.id);
        if (existingItem) {
            existingItem.quantity += product.quantity;
        } else {
            cart.push(product);
        }
        displayCartItems(); // Tampilkan kembali item keranjang belanja setelah ditambahkan
        updateCart(); // Perbarui total harga keranjang belanja
    }

    function removeFromCart(cartItemId) {
        cart = cart.filter(item => item.id !== cartItemId);
        displayCartItems(); // Tampilkan kembali item keranjang belanja setelah dihapus
        updateCart(); // Perbarui total harga keranjang belanja
    }

    function displayCartItems() {
        var cartItemsContainer = document.getElementById('cartItemsContainer');
        cartItemsContainer.innerHTML = '';
        cart.forEach(item => {
            var itemElement = document.createElement('div');
            itemElement.classList.add('bg-gray-100', 'rounded-lg', 'shadow-md', 'p-4', 'mb-2');
            itemElement.innerHTML = `
                <p class="text-gray-700">${item.nama} x ${item.quantity}</p>
                <p class="text-gray-700">Rp${item.harga * item.quantity}</p>
                <p class="text-gray-700">Subtotal: Rp<span id="subtotal${item.id}">${item.harga * item.quantity}</span></p>
                <button onclick="removeFromCart('${item.id}')" class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md">Remove</button>
            `;
            cartItemsContainer.appendChild(itemElement);
        });
    }

    function updateCart() {
        var totalPrice = 0;
        cart.forEach(item => {
            totalPrice += item.harga * item.quantity;
        });
        document.getElementById('totalPrice').innerText = 'Rp' + totalPrice.toFixed(2); // Format total harga dengan 2 angka di belakang koma
    }

    function openModal() {
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    function confirmOrder() {
    // Kirim data keranjang belanja ke server menggunakan AJAX
    fetch('/confirm-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(cart)
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Network response was not ok.');
    })
    .then(data => {
        // Tampilkan pesan sukses atau error, dan lakukan tindakan sesuai kebutuhan
        console.log(data);
        closeModal(); // Tutup modal setelah konfirmasi berhasil
    })
    .catch(error => {
        console.error('There was a problem with your fetch operation:', error);
        // Tampilkan pesan error kepada pengguna
    });
}
</script>
@endsection