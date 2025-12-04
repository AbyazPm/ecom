<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Modern E-commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 flex justify-center items-center min-h-screen p-4">

    <div class="w-full max-w-4xl bg-white shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row">

        <!-- Banner kiri -->
        <div class="hidden md:block w-1/2 bg-cover bg-center relative"
            style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1000&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-8">
                <h2 class="text-white text-3xl font-bold mb-2">New Arrival</h2>
                <p class="text-gray-200 text-sm">Temukan koleksi fashion terbaru dengan harga terbaik hari ini.</p>
            </div>
        </div>

        <!-- Form Login -->
        <div class="w-full md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center">

            <div class="mb-6 text-center md:text-left">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang Kembali! 👋</h1>
                <p class="text-gray-500 text-sm">Silakan masukkan detail akun kamu untuk mulai belanja.</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

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

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Tombol Login -->
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                    Log in
                </button>
            </form>

            <!-- Daftar -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                        class="font-semibold text-indigo-600 hover:text-indigo-500 transition">
                        Daftar Sekarang
                    </a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>
