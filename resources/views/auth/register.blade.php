<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Modern E-commerce</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 flex justify-center items-center min-h-screen p-4">

    <div class="w-full max-w-4xl bg-white shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row">

        <!-- Banner kiri -->
        <div class="hidden md:flex md:w-1/2 bg-cover bg-center relative"
            style="background-image: url('https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=1000&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-indigo-900 bg-opacity-40 flex flex-col justify-end p-8">
                <h2 class="text-white text-3xl font-bold mb-2">Join Our Community</h2>
                <p class="text-gray-200 text-sm">
                    Dapatkan akses eksklusif ke ribuan produk fashion terbaru.
                </p>
            </div>
        </div>

        <!-- Form Register -->
        <div class="w-full md:w-1/2 p-8 md:p-12 bg-white">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Buat Akun Baru 🚀</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Lengkapi data diri kamu untuk mendaftar.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                        value="{{ old('name') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border"
                        placeholder="John Doe" required>

                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border"
                        placeholder="nama@email.com" required>

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border"
                        placeholder="••••••••" required>

                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border"
                        placeholder="••••••••" required>

                    @error('password_confirmation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Register -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </button>
                </div>

                <!-- Login Link -->
                <div class="flex items-center justify-center mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        Sudah punya akun? 
                        <span class="text-indigo-600 font-bold">Login disini</span>
                    </a>
                </div>

            </form>

        </div>
    </div>

</body>
</html>
