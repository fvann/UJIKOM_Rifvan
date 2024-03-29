<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PALMART - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 dark:bg-gray-700">
    <div class="min-h-screen flex items-center justify-center ">
        <div class="max-w-md w-full bg-gray-800 dark:bg-gray-600 shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <h2 class="text-center text-gray-100 font-semibold text-xl">Login</h2>
                <form action="{{ route('authenticate') }}" method="post" class="mt-8">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-gray-300 text-sm font-semibold mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input w-full rounded-md @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>                    
                    <div class="mb-4">
                        <label for="password" class="block text-gray-300 text-sm font-semibold mb-2">Password</label>
                        <input type="password" id="password" name="password" class="form-input w-full rounded-md @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Login
                        </button>
                    </div>
                </form>
                <div class="mt-4 text-center">
                    <span class="text-sm text-gray-300">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
