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
                <button id="deleteButton{{ $cart_item->id }}" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-red-500 hover:text-red-800 rounded-lg focus:outline-none dark:text-red-400 dark:hover:text-red-100" type="button" onclick="openDeleteModal('{{ $cart_item->id }}')">
                    Delete
                </button>
            </div>
            @endforeach
        </div>
        <hr class="my-4">
        <div id="totalContainer" class="flex justify-between items-center">
            <span class="text-lg font-bold text-white">Total: </span>
            <!-- Menampilkan total harga -->
            <span id="totalPrice" class="text-lg font-bold text-white"></span>
        </div>
        <!-- Tombol checkout -->
        <button onclick="checkout()" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md">Checkout</button>
    </div>
</div>
</div>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('deleteModal')">&times;</span>
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Delete Produk</h2>
        <p class="text-gray-700">Are you sure you want to delete this produk?</p>
        <div class="mt-4 flex justify-end space-x-4">
            <button type="button" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" onclick="closeModal('deleteModal')">Cancel</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-red-700 bg-red-200 hover:bg-red-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Delete</button>
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

    function checkout() {
        // Implement checkout logic here
        // You can send the cart data to the server for processing
        console.log(cart);
        // After checkout, you may want to clear the cart and update the UI accordingly
        cart = [];
        displayCartItems(); // Perbarui tampilan setelah checkout
        updateCart(); // Perbarui total harga setelah checkout
    }

    function openDeleteModal(id) {
        var modal = document.getElementById("deleteModal");
        modal.style.display = "block";
        $('#deleteForm').attr('action', '/delete/' + id); // Set action URL dynamically
    }

    $('#deleteForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    // Handle success response, if needed
                    closeModal('deleteModal');
                }
            });
        });
</script>
@endsection
