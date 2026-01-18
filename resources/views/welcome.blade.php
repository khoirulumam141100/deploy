<x-layouts.app title="Beranda">
    <!-- Header/Navbar -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                        <span class="text-white text-lg">🏘️</span>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900">KAUMAN</div>
                        <div class="text-xs text-gray-500">Dusun Kauman, Desa Deras</div>
                    </div>
                </a>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#features"
                        class="text-sm font-medium text-gray-600 hover:text-green-600 transition-colors">Fitur</a>
                    <a href="#structure"
                        class="text-sm font-medium text-gray-600 hover:text-green-600 transition-colors">Struktur</a>
                    <a href="#about"
                        class="text-sm font-medium text-gray-600 hover:text-green-600 transition-colors">Tentang</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('warga.dashboard') }}" class="btn-primary">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 hover:text-green-600 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary">Daftar Warga</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-16 overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-green-50 via-white to-teal-50"></div>
        <div class="absolute top-20 right-0 w-96 h-96 bg-green-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-0 w-80 h-80 bg-teal-200/30 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium mb-6">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        Dusun Kauman • Desa Deras
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Sistem Informasi<br>
                        <span class="text-green-600">Warga Kauman</span>
                    </h1>

                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg">
                        Platform digital untuk mengelola data warga, keuangan RT/RW, kegiatan lingkungan, dan program
                        bank sampah di Dusun Kauman, Desa Deras.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        @auth
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('warga.dashboard') }}"
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-green-600/25 transition-all">
                                Masuk Dashboard
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-green-600/25 transition-all">
                                Daftar Sebagai Warga
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-xl font-semibold border border-gray-200 transition-all">
                                Sudah Punya Akun
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-600 to-teal-600 rounded-3xl transform rotate-3">
                    </div>
                    <div class="relative bg-white rounded-3xl p-8 shadow-xl">
                        @php
                            $totalResidents = \App\Models\User::active()->residents()->count();
                            $totalEvents = \App\Models\Event::count();
                            $totalDeposits = \App\Models\WasteDeposit::count();
                            $totalWeight = \App\Models\WasteDeposit::sum('weight');
                        @endphp
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Statistik Dusun Kauman</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="p-4 bg-green-50 rounded-xl">
                                <div class="text-3xl font-bold text-green-600">{{ $totalResidents }}</div>
                                <div class="text-sm text-gray-600 mt-1">Warga Aktif</div>
                            </div>
                            <div class="p-4 bg-teal-50 rounded-xl">
                                <div class="text-3xl font-bold text-teal-600">4 RT</div>
                                <div class="text-sm text-gray-600 mt-1">dalam 2 RW</div>
                            </div>
                            <div class="p-4 bg-amber-50 rounded-xl">
                                <div class="text-3xl font-bold text-amber-600">{{ $totalEvents }}</div>
                                <div class="text-sm text-gray-600 mt-1">Kegiatan</div>
                            </div>
                            <div class="p-4 bg-blue-50 rounded-xl">
                                <div class="text-3xl font-bold text-blue-600">{{ number_format($totalWeight, 0) }} kg
                                </div>
                                <div class="text-sm text-gray-600 mt-1">Sampah Terkumpul</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-medium mb-4">
                    ✨ Fitur
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Kelola lingkungan RT/RW Dusun Kauman dengan mudah dan transparan
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div
                    class="group relative bg-white rounded-2xl p-6 border border-gray-100 hover:border-green-200 hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-bl-[80px] -z-10 group-hover:bg-green-100 transition-colors">
                    </div>
                    <div
                        class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-5 text-2xl group-hover:bg-green-600 group-hover:text-white transition-colors">
                        👥
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Data Warga</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Kelola data warga per RT/RW dengan status kependudukan yang lengkap dan terstruktur.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="group relative bg-white rounded-2xl p-6 border border-gray-100 hover:border-teal-200 hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-teal-50 rounded-bl-[80px] -z-10 group-hover:bg-teal-100 transition-colors">
                    </div>
                    <div
                        class="w-14 h-14 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center mb-5 text-2xl group-hover:bg-teal-600 group-hover:text-white transition-colors">
                        💰
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Keuangan Transparan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Catat pemasukan dan pengeluaran kas RT secara transparan dan dapat diakses warga.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="group relative bg-white rounded-2xl p-6 border border-gray-100 hover:border-amber-200 hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-amber-50 rounded-bl-[80px] -z-10 group-hover:bg-amber-100 transition-colors">
                    </div>
                    <div
                        class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-5 text-2xl group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        📅
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Kegiatan Lingkungan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Informasi kegiatan RT/RW seperti pengajian rutin, kerja bakti, dan posyandu.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="group relative bg-white rounded-2xl p-6 border border-gray-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-emerald-50 rounded-bl-[80px] -z-10 group-hover:bg-emerald-100 transition-colors">
                    </div>
                    <div
                        class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-5 text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        ♻️
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Bank Sampah</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Setor sampah, kumpulkan saldo, dan tukarkan kapan saja. Lingkungan bersih, warga sejahtera.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Structure Section -->
    <section id="structure" class="py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-teal-100 text-teal-700 rounded-full text-sm font-medium mb-4">
                    🏘️ Struktur Wilayah
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Struktur RT/RW Kauman</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Dusun Kauman, Desa Deras terdiri dari 2 RW dan 4 RT yang terintegrasi dalam satu sistem
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- RW 01 -->
                <div
                    class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="h-2 bg-gradient-to-r from-green-500 to-green-600"></div>
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                                01
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">RW 01</h3>
                                <p class="text-gray-500">Rukun Warga 01</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="p-4 bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl border border-green-100">
                                <div class="text-xl font-bold text-green-700">RT 03</div>
                                <p class="text-sm text-green-600 mt-1">Rukun Tetangga</p>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl border border-green-100">
                                <div class="text-xl font-bold text-green-700">RT 04</div>
                                <p class="text-sm text-green-600 mt-1">Rukun Tetangga</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RW 02 -->
                <div
                    class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="h-2 bg-gradient-to-r from-teal-500 to-teal-600"></div>
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center text-white text-xl font-bold shadow-lg">
                                02
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">RW 02</h3>
                                <p class="text-gray-500">Rukun Warga 02</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="p-4 bg-gradient-to-br from-teal-50 to-teal-100/50 rounded-xl border border-teal-100">
                                <div class="text-xl font-bold text-teal-700">RT 01</div>
                                <p class="text-sm text-teal-600 mt-1">Rukun Tetangga</p>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-teal-50 to-teal-100/50 rounded-xl border border-teal-100">
                                <div class="text-xl font-bold text-teal-700">RT 02</div>
                                <p class="text-sm text-teal-600 mt-1">Rukun Tetangga</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-amber-100 text-amber-700 rounded-full text-sm font-medium mb-4">
                        ℹ️ Tentang
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Tentang Sistem Kauman
                    </h2>
                    <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                        <strong>Kauman</strong> adalah sistem informasi warga terintegrasi untuk Dusun Kauman, Desa
                        Deras.
                        Platform ini memudahkan pengelolaan data warga, keuangan RT/RW, kegiatan lingkungan, dan program
                        bank sampah.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Dengan sistem digital ini, warga dapat mengakses informasi secara transparan, pengurus RT/RW
                        dapat mengelola data dengan efisien, dan lingkungan menjadi lebih bersih melalui program bank
                        sampah.
                    </p>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <div
                                class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-sm">
                                ✓</div>
                            <span class="text-gray-700 text-sm font-medium">Data warga per RT</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <div
                                class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-sm">
                                ✓</div>
                            <span class="text-gray-700 text-sm font-medium">Transparansi keuangan</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <div
                                class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-sm">
                                ✓</div>
                            <span class="text-gray-700 text-sm font-medium">Bank sampah</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <div
                                class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-sm">
                                ✓</div>
                            <span class="text-gray-700 text-sm font-medium">Info kegiatan</span>
                        </div>
                    </div>

                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-green-600/25 transition-all">
                        Daftar Sebagai Warga
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <!-- Data Warga -->
                    <div
                        class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                        <div
                            class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                            🏠
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Data Warga</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Kelola data warga dengan mudah dan terstruktur
                        </p>
                    </div>

                    <!-- Keuangan -->
                    <div
                        class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                        <div
                            class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                            💵
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Keuangan</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Transparansi keuangan RT/RW
                        </p>
                    </div>

                    <!-- Informasi -->
                    <div
                        class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                        <div
                            class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                            📢
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Informasi</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Kegiatan dan pengumuman terkini
                        </p>
                    </div>

                    <!-- Bank Sampah -->
                    <div
                        class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
                        <div
                            class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                            ♻️
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Bank Sampah</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            Lingkungan bersih, warga sejahtera
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-green-600 to-teal-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2">
            </div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Bergabung Bersama Kami
            </h2>
            <p class="text-lg text-white/90 mb-10 max-w-2xl mx-auto">
                Jadilah warga terdaftar Dusun Kauman, Desa Deras. Akses informasi lingkungan, transparansi keuangan, dan
                nikmati program bank sampah.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-green-600 px-8 py-4 rounded-xl font-bold text-lg shadow-xl transition-all">
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white border-2 border-white/30 px-8 py-4 rounded-xl font-bold text-lg transition-all">
                    Sudah Punya Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 items-center">
                <div class="flex items-center gap-3">
                    <div
                        class="w-11 h-11 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white text-lg">🏘️</span>
                    </div>
                    <div>
                        <div class="font-bold text-lg text-white">KAUMAN</div>
                        <div class="text-sm">Dusun Kauman, Desa Deras</div>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-8 text-sm">
                    <a href="#features" class="hover:text-white transition-colors">Fitur</a>
                    <a href="#structure" class="hover:text-white transition-colors">Struktur</a>
                    <a href="#about" class="hover:text-white transition-colors">Tentang</a>
                </div>
                <div class="text-right">
                    <p class="text-sm">&copy; {{ date('Y') }} Kauman</p>
                    <p class="text-xs mt-1">Sistem Informasi Warga RT/RW</p>
                </div>
            </div>
        </div>
    </footer>
</x-layouts.app>