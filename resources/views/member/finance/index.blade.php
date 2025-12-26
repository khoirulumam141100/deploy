<x-layouts.member :title="'Keuangan'" :header="'Transparansi Keuangan'">
    <!-- Page Header -->
    <div class="mb-6">
        <p class="text-gray-600">Lihat laporan keuangan organisasi PADRP ASSYUKRO secara transparan</p>
    </div>

    <!-- Total Balance -->
    <div class="card bg-gradient-to-r from-secondary-600 to-secondary-700 text-white mb-6">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-secondary-100">Total Saldo Organisasi</p>
                    <h2 class="text-3xl font-bold mt-1">{{ $formattedBalance }}</h2>
                </div>
                <div class="text-6xl opacity-20">💰</div>
            </div>
        </div>
    </div>

    <!-- Category Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($categories as $category)
            <a href="{{ route('member.finance.category', $category) }}"
                class="card hover:shadow-lg transition-shadow group">
                <div class="card-body">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl
                                    @if($category->color === 'teal') bg-teal-100
                                    @elseif($category->color === 'green') bg-green-100
                                    @elseif($category->color === 'purple') bg-purple-100
                                    @elseif($category->color === 'yellow') bg-yellow-100
                                    @else bg-gray-100
                                    @endif
                                ">
                            {{ $category->icon }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $category->description }}</p>

                            <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                                <div>
                                    <div class="text-xs text-gray-500">Pemasukan</div>
                                    <div class="text-sm font-medium text-green-600">{{ $category->formatted_income }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Pengeluaran</div>
                                    <div class="text-sm font-medium text-red-600">{{ $category->formatted_expense }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Saldo</div>
                                    <div class="text-sm font-bold text-gray-900">{{ $category->formatted_balance }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-gray-400 group-hover:text-primary-600 transition-colors">
                            →
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Transparency Note -->
    <div class="card mt-6 bg-green-50 border-green-200">
        <div class="card-body">
            <div class="flex items-start gap-4">
                <div class="text-3xl">ℹ️</div>
                <div>
                    <h4 class="font-semibold text-green-900">Tentang Transparansi Keuangan</h4>
                    <p class="text-sm text-green-800 mt-1">
                        Halaman ini menampilkan laporan keuangan organisasi secara transparan.
                        Setiap anggota dapat melihat pemasukan dan pengeluaran pada masing-masing kategori.
                        Klik pada kategori untuk melihat rincian transaksi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.member>