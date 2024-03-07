@extends('layout.mainlayout')

@section('content')
<div class="h-full ml-14 mt-14 mb-10 md:ml-64">

<!-- Start block -->
<div class="mx-auto max-w-screen-xl px-4 lg:px-12 mt-10">
    <!-- Start coding here -->
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" onclick="openModal()">
                Add Produk
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-80 dark:bg-gray-800 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-4">Nama Produk</th>
                        <th scope="col" class="px-4 py-3">Harga</th>
                        <th scope="col" class="px-4 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $product->nama }}</td>
                        <td class="px-4 py-3">{{ $product->harga }}</td>
                        <td class="px-4 py-3 flex items-center">
                            <button id="editButton{{ $product->id }}" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button" onclick="openEditModal('{{ $product->id }}', '{{ $product->nama }}', '{{ $product->harga }}')">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                </svg>
                                Edit
                            </button>
                            <button id="deleteButton{{ $product->id }}" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-red-500 hover:text-red-800 rounded-lg focus:outline-none dark:text-red-400 dark:hover:text-red-100" type="button" onclick="openDeleteModal('{{ $product->id }}')">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 15" fill="none" aria-hidden="true">
                                    <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" d="M6.09922 0.300781C5.93212 0.30087 5.76835 0.347476 5.62625 0.435378C5.48414 0.523281 5.36931 0.649009 5.29462 0.798481L4.64302 2.10078H1.59922C1.36052 2.10078 1.13161 2.1956 0.962823 2.36439C0.79404 2.53317 0.699219 2.76209 0.699219 3.00078C0.699219 3.23948 0.79404 3.46839 0.962823 3.63718C1.13161 3.80596 1.36052 3.90078 1.59922 3.90078V12.9008C1.59922 13.3782 1.78886 13.836 2.12643 14.1736C2.46399 14.5111 2.92183 14.7008 3.39922 14.7008H10.5992C11.0766 14.7008 11.5344 14.5111 11.872 14.1736C12.2096 13.836 12.3992 13.3782 12.3992 12.9008V3.90078C12.6379 3.90078 12.8668 3.80596 13.0356 3.63718C13.2044 3.46839 13.2992 3.23948 13.2992 3.00078C13.2992 2.76209 13.2044 2.53317 13.0356 2.36439C12.8668 2.1956 12.6379 2.10078 12.3992 2.10078H9.35542L8.70382 0.798481C8.62913 0.649009 8.5143 0.523281 8.37219 0.435378C8.23009 0.347476 8.06631 0.30087 7.89922 0.300781H6.09922ZM4.29922 5.70078C4.29922 5.46209 4.39404 5.23317 4.56282 5.06439C4.73161 4.8956 4.96052 4.80078 5.19922 4.80078C5.43791 4.80078 5.66683 4.8956 5.83561 5.06439C6.0044 5.23317 6.09922 5.46209 6.09922 5.70078V11.1008C6.09922 11.3395 6.0044 11.5684 5.83561 11.7372C5.66683 11.906 5.43791 12.0008 5.19922 12.0008C4.96052 12.0008 4.73161 11.906 4.56282 11.7372C4.39404 11.5684 4.29922 11.3395 4.29922 11.1008V5.70078ZM8.79922 4.80078C8.56052 4.80078 8.33161 4.8956 8.16282 5.06439C7.99404 5.23317 7.89922 5.46209 7.89922 5.70078V11.1008C7.89922 11.3395 7.99404 11.5684 8.16282 11.7372C8.33161 11.906 8.56052 12.0008 8.79922 12.0008C9.03791 12.0008 9.26683 11.906 9.43561 11.7372C9.6044 11.5684 9.69922 11.3395 9.69922 11.1008V5.70078C9.69922 5.46209 9.6044 5.23317 9.43561 5.06439C9.26683 4.8956 9.03791 4.80078 8.79922 4.80078Z" />
                                </svg>
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End coding here -->
</div>

<div id="editModal" class="modal bg-white dark:bg-gray-800">
    <div class="modal-content dark:bg-gray-800">
        <span class="close" onclick="closeModal('editModal')">&times;</span>
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Edit Produk</h2>
        <form id="editForm" method="POST" class="px-4 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="edit-nama" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" id="edit-nama" name="nama" autocomplete="nama" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300" value="">
            </div>
            <div>
                <label for="edit-harga" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" id="edit-harga" name="harga" autocomplete="harga" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300" value="">
            </div>
            <div>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Save Changes</button>
            </div>
        </form>        
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

<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addModal')">&times;</span>
        <form id="addForm" action="{{ route('products.store') }}" method="POST" class="px-4 py-6 space-y-4">
            @csrf
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" id="nama" name="nama" autocomplete="nama" class="text-gray-700 mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" id="harga" name="harga" autocomplete="harga" class="text-gray-700 mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Submit</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function openEditModal(id, nama, harga) {
        var modal = document.getElementById("editModal");
        modal.style.display = "block";
        document.getElementById("edit-nama").value = nama;
        document.getElementById("edit-harga").value = harga;
        $('#editForm').attr('action', '/products/' + id); // Set action URL dynamically
    }

    function openDeleteModal(id) {
        var modal = document.getElementById("deleteModal");
        modal.style.display = "block";
        $('#deleteForm').attr('action', '/products/' + id); // Set action URL dynamically
    }

    $(document).ready(function() {
        $('#editForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    // Handle success response, if needed
                    closeModal('editModal');
                }
            });
        });

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

        $('#addForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    // Handle success response, if needed
                    closeModal('addModal');
                }
            });
        });
    });

    function openModal() {
        var modal = document.getElementById("addModal");
        modal.style.display = "block";
    }

    function closeModal(id) {
        var modal = document.getElementById(id);
        modal.style.display = "none";
    }
</script>

@endsection