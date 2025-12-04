<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Modern E-commerce</title>

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
             style="background-image: url('https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?q=80&w=1000&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-indigo-900 bg-opacity-50 flex flex-col justify-end p-8">
                <h2 class="text-white text-3xl font-bold mb-2">Account Recovery</h2>
                <p class="text-gray-200 text-sm">Keamanan akun Anda adalah prioritas kami.</p>
            </div>
        </div>

        <!-- Form Forgot Password -->
        <div class="w-full md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center">

            <!-- Icon & Title -->
            <div class="mb-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Lupa Password? 🔒</h1>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                    Masukkan email Anda dan kami akan mengirimkan link untuk mereset password Anda.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm font-semibold text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email input -->
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email Address</label>

                    <input id="email" name="email" type="email"
                           value="{{ old('email') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border"
                           placeholder="nama@email.com"
                           required autofocus>

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit button -->
                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                        Kirim Link Reset
                    </button>
                </div>

                <!-- Back to login -->
                <div class="flex items-center justify-center mt-4">
                    <a href="{{ route('login') }}"
                       class="flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Login
                    </a>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
