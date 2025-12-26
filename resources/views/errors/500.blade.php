<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Kesalahan Server | PADRP ASSYUKRO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-yellow-50/30 to-orange-50/30">
    <div class="text-center px-6">
        <!-- Illustration -->
        <div class="text-9xl mb-6">⚠️</div>

        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-gray-900 mb-4">500</h1>

        <!-- Message -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Kesalahan Server</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Maaf, terjadi kesalahan pada server kami. Tim teknis kami sedang memperbaikinya.
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="btn-primary text-lg px-8 py-3">
                🏠 Kembali ke Beranda
            </a>
            <button onclick="location.reload()" class="btn-outline text-lg px-8 py-3">
                🔄 Coba Lagi
            </button>
        </div>

        <!-- Footer -->
        <p class="text-sm text-gray-500 mt-12">
            &copy; {{ date('Y') }} PADRP ASSYUKRO. All rights reserved.
        </p>
    </div>
</body>

</html>