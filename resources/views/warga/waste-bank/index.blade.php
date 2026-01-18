<x-layouts.warga :title="'Bank Sampah'" :header="'Bank Sampah'">
    <!-- Balance Card -->
    <div class="card mb-8 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-emerald-100">Saldo Bank Sampah Anda</div>
                    <div class="text-4xl font-bold mt-2">{{ $formattedBalance }}</div>
                    <div class="text-emerald-100 text-sm mt-2">
                        {{ $stats['total_deposits'] }} setoran • {{ number_format($stats['total_weight'], 1) }} kg total
                    </div>
                </div>
                <div class="text-8xl opacity-30">♻️</div>
            </div>
            <div class="flex gap-3 mt-6">
                <a href="{{ route('warga.waste-bank.history') }}"
                    class="btn bg-white/20 hover:bg-white/30 text-white border-0">
                    📋 Riwayat Setoran
                </a>
                <a href="{{ route('warga.waste-bank.redeem') }}"
                    class="btn bg-white text-emerald-600 hover:bg-gray-100 border-0">
                    💵 Tukar Saldo
                </a>
            </div>
        </div>
    </div>

    <!-- Info Cara Setor -->
    <div class="card bg-blue-50 border-blue-200 mb-8">
        <div class="card-body flex items-start gap-4">
            <div class="text-3xl">ℹ️</div>
            <div>
                <h4 class="font-bold text-blue-900">Cara Setor Sampah</h4>
                <p class="text-blue-800 text-sm mt-1">
                    Untuk menyetor sampah, silakan bawa sampah terpilah Anda ke <strong>Posko Bank Sampah
                        Kauman</strong> pada jam operasional.
                    Petugas kami akan menimbang dan mencatat setoran Anda ke dalam sistem, dan saldo akan otomatis
                    bertambah di akun ini.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="card p-4 text-center">
            <div class="text-3xl font-bold text-gray-900">{{ $stats['total_deposits'] }}</div>
            <div class="text-sm text-gray-500 mt-1">Total Setoran</div>
        </div>
        <div class="card p-4 text-center">
            <div class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_weight'], 1) }} kg</div>
            <div class="text-sm text-gray-500 mt-1">Total Berat</div>
        </div>
        <div class="card p-4 text-center">
            <div class="text-3xl font-bold text-emerald-600">{{ $stats['formatted_earned'] }}</div>
            <div class="text-sm text-gray-500 mt-1">Total Pendapatan</div>
        </div>
        <div class="card p-4 text-center">
            <div class="text-3xl font-bold text-amber-600">{{ $stats['pending_redemptions'] }}</div>
            <div class="text-sm text-gray-500 mt-1">Penukaran Pending</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Deposit Breakdown by Type -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Setoran per Jenis Sampah</h3>
            </div>
            <div class="card-body p-0">
                @forelse($depositsByType as $item)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">{{ $item['icon'] }}</span>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $item['name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ number_format($item['total_weight'], 1) }} kg
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-emerald-600">{{ $item['formatted_value'] }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <div class="text-4xl mb-2">📦</div>
                        <p>Belum ada setoran sampah</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Deposits -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Setoran Terakhir</h3>
                <a href="{{ route('warga.waste-bank.history') }}" class="text-sm text-green-600 hover:text-green-700">
                    Lihat Semua →
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($recentDeposits as $deposit)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">{{ $deposit->wasteType->icon }}</span>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $deposit->wasteType->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $deposit->deposit_date->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-medium text-gray-900">{{ $deposit->formatted_weight }}</div>
                                <div class="text-sm text-emerald-600">+{{ $deposit->formatted_amount }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <div class="text-4xl mb-2">📦</div>
                        <p>Belum ada setoran sampah</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Waste Types & Prices -->
    <div class="card mt-6">
        <div class="card-header">
            <h3 class="font-semibold text-gray-900">Daftar Harga Sampah</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                @foreach($wasteTypes as $type)
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-3xl mb-2">{{ $type->icon }}</div>
                        <div class="font-medium text-sm text-gray-900">{{ $type->name }}</div>
                        <div class="text-emerald-600 font-semibold mt-1">{{ $type->formatted_price }}/kg</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Pending Redemptions -->
    @if($pendingRedemptions->count() > 0)
        <div class="card mt-6">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Penukaran Menunggu Konfirmasi</h3>
            </div>
            <div class="card-body p-0">
                @foreach($pendingRedemptions as $redemption)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ $redemption->formatted_amount }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $redemption->redemption_type->label() }} •
                                    {{ $redemption->created_at->format('d M Y H:i') }}
                                </div>
                            </div>
                            <span class="{{ $redemption->status->badgeClass() }}">
                                {{ $redemption->status->label() }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-layouts.warga>