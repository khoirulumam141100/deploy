<x-layouts.app title="Selamat Datang">
    <!-- Header/Navbar -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 items-center h-16">
                <!-- Logo - Left -->
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PADRP Assyukro"
                        class="w-10 h-10 rounded-xl shadow-lg">
                    <div>
                        <div class="font-bold text-gray-900">PADRP ASSYUKRO</div>
                        <div class="text-xs text-gray-500">Persatuan Anak Daerah, Pesantren, dan Rantau</div>
                    </div>
                </a>

                <!-- Navigation - Center -->
                <nav class="hidden md:flex items-center justify-center gap-8">
                    <a href="#features"
                        class="text-sm font-medium text-gray-600 hover:text-primary-600 transition-colors">Fitur</a>
                    <a href="#about"
                        class="text-sm font-medium text-gray-600 hover:text-primary-600 transition-colors">Tentang</a>
                </nav>

                <!-- Auth Buttons - Right -->
                <div class="flex items-center justify-end gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="btn-primary">
                                Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 hover:text-primary-600 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section
        class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-gray-50 via-primary-50/30 to-secondary-50/30 pt-16">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-30">
            <div
                class="absolute top-20 left-10 w-72 h-72 bg-primary-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob">
            </div>
            <div
                class="absolute top-40 right-10 w-72 h-72 bg-secondary-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-20 w-72 h-72 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <!-- Badge -->
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-8">
                <span class="w-2 h-2 bg-primary-500 rounded-full animate-pulse"></span>
                Organisasi Pemuda Terpercaya
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                Selamat Datang di<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600">
                    PADRP ASSYUKRO
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-10">
                <strong>Persatuan Anak Daerah, Pesantren, dan Rantau</strong><br>
                Platform digital untuk mengelola organisasi secara transparan, modern, dan efisien.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="btn-primary text-lg px-8 py-3 shadow-lg shadow-primary-500/30">
                            Masuk ke Dashboard
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('member.dashboard') }}"
                            class="btn-primary text-lg px-8 py-3 shadow-lg shadow-primary-500/30">
                            Masuk ke Dashboard
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-3 shadow-lg shadow-primary-500/30">
                        Daftar Jadi Anggota
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="btn-outline text-lg px-8 py-3">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Masuk
                    </a>
                @endauth
            </div>

            <!-- Stats -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8">
                @php
                    $totalMembers = \App\Models\User::active()->members()->count();
                    $totalEvents = \App\Models\Event::count();
                @endphp
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-gray-900">{{ $totalMembers }}+</div>
                    <div class="text-gray-500 mt-1">Anggota Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-gray-900">4</div>
                    <div class="text-gray-500 mt-1">Kategori Keuangan</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-gray-900">{{ $totalEvents }}+</div>
                    <div class="text-gray-500 mt-1">Kegiatan</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-gray-900">100%</div>
                    <div class="text-gray-500 mt-1">Transparan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Kelola organisasi dengan mudah dan transparan menggunakan fitur-fitur modern kami.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="card p-8 text-center hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="w-16 h-16 bg-primary-100 text-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">
                        👥
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Manajemen Keanggotaan</h3>
                    <p class="text-gray-600">
                        Kelola data anggota dengan mudah. Sistem pendaftaran online dengan approval admin.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="card p-8 text-center hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="w-16 h-16 bg-secondary-100 text-secondary-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">
                        💰
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Keuangan Transparan</h3>
                    <p class="text-gray-600">
                        Catat dan tampilkan keuangan organisasi secara transparan. Anggota dapat melihat laporan
                        keuangan.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="card p-8 text-center hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">
                        📅
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Informasi Kegiatan</h3>
                    <p class="text-gray-600">
                        Informasikan kegiatan organisasi kepada seluruh anggota. Lihat kegiatan yang akan datang dan
                        yang sudah lewat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Tentang PADRP ASSYUKRO
                    </h2>
                    <p class="text-lg text-gray-600 mb-6">
                        <strong>PADRP ASSYUKRO</strong> adalah singkatan dari <em>Persatuan Anak Daerah, Pesantren, dan
                            Rantau</em>.
                        Organisasi pemuda ini bertujuan untuk mempersatukan dan mengembangkan potensi anak-anak daerah,
                        santri pesantren, dan perantau dalam satu wadah yang solid.
                    </p>
                    <p class="text-lg text-gray-600 mb-8">
                        Dengan platform digital ini, kami berkomitmen untuk mengelola organisasi secara transparan,
                        modern, dan efisien demi kemajuan bersama.
                    </p>
                    <a href="{{ route('register') }}" class="btn-primary">
                        Bergabung Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="card p-6 bg-gradient-to-br from-primary-500 to-primary-600 text-white">
                        <div class="text-3xl mb-3">🏠</div>
                        <h4 class="font-semibold mb-1">Anak Daerah</h4>
                        <p class="text-sm opacity-90">Memperkuat akar dan identitas daerah</p>
                    </div>
                    <div class="card p-6 bg-gradient-to-br from-secondary-500 to-secondary-600 text-white">
                        <div class="text-3xl mb-3">🕌</div>
                        <h4 class="font-semibold mb-1">Pesantren</h4>
                        <p class="text-sm opacity-90">Menjaga nilai-nilai keagamaan</p>
                    </div>
                    <div class="card p-6 bg-gradient-to-br from-yellow-500 to-orange-500 text-white">
                        <div class="text-3xl mb-3">✈️</div>
                        <h4 class="font-semibold mb-1">Rantau</h4>
                        <p class="text-sm opacity-90">Menghubungkan perantau dengan tanah air</p>
                    </div>
                    <div class="card p-6 bg-gradient-to-br from-purple-500 to-pink-500 text-white">
                        <div class="text-3xl mb-3">🤝</div>
                        <h4 class="font-semibold mb-1">Bersatu</h4>
                        <p class="text-sm opacity-90">Membangun kebersamaan yang kuat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-r from-primary-600 to-primary-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Siap Bergabung Bersama Kami?
            </h2>
            <p class="text-lg text-primary-100 mb-8 max-w-2xl mx-auto">
                Jadilah bagian dari keluarga besar PADRP ASSYUKRO. Daftarkan diri Anda sekarang dan nikmati berbagai
                manfaat keanggotaan.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="bg-white text-primary-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}"
                    class="text-white border-2 border-white/50 hover:border-white hover:bg-white/10 px-8 py-3 rounded-lg font-semibold transition-all">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PADRP Assyukro" class="w-10 h-10 rounded-xl">
                    <div>
                        <div class="font-bold text-white">PADRP ASSYUKRO</div>
                        <div class="text-xs">Persatuan Anak Daerah, Pesantren, dan Rantau</div>
                    </div>
                </div>
                <p class="text-sm">
                    &copy; {{ date('Y') }} PADRP ASSYUKRO. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    @push('styles')
        <style>
            @keyframes blob {
                0% {
                    transform: translate(0px, 0px) scale(1);
                }

                33% {
                    transform: translate(30px, -50px) scale(1.1);
                }

                66% {
                    transform: translate(-20px, 20px) scale(0.9);
                }

                100% {
                    transform: translate(0px, 0px) scale(1);
                }
            }

            .animate-blob {
                animation: blob 7s infinite;
            }

            .animation-delay-2000 {
                animation-delay: 2s;
            }

            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    @endpush
</x-layouts.app>