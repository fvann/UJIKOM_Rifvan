<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PALMART - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white dark:bg-gray-700">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-800">
        <!-- Card component -->
        <div class="max-w-md w-full bg-white dark:bg-gray-700 shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <h2 class="text-center font-semibold text-xl text-gray-800 dark:text-white">Register</h2>
                <form action="{{ route('store') }}" method="post" class="mt-8">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input w-full @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input w-full @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Password</label>
                        <input type="password" id="password" name="password" class="form-input w-full @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input w-full">
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
