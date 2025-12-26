<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | PADRP ASSYUKRO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-red-50/30 to-orange-50/30">
    <div class="text-center px-6">
        <!-- Illustration -->
        <div class="text-9xl mb-6">🚫</div>

        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-gray-900 mb-4">403</h1>

        <!-- Message -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Akses Ditolak</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="btn-primary text-lg px-8 py-3">
                🏠 Kembali ke Beranda
            </a>
            <button onclick="history.back()" class="btn-outline text-lg px-8 py-3">
                ← Kembali
            </button>
        </div>

        <!-- Footer -->
        <p class="text-sm text-gray-500 mt-12">
            &copy; {{ date('Y') }} PADRP ASSYUKRO. All rights reserved.
        </p>
    </div>
</body>

</html>