<x-layouts.warga :title="'Dashboard'" :header="'Beranda'">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ $user->name }}! 👋</h2>
        <p class="text-gray-600 mt-1">
            Lihat informasi terbaru tentang lingkungan {{ $user->rt?->full_name ?? 'Dusun Kauman' }}.
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Waste Balance -->
        <div class="card p-6 bg-gradient-to-br from-emerald-500 to-teal-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-emerald-100 text-sm">Saldo Bank Sampah</div>
                    <div class="text-2xl font-bold mt-1">{{ $formattedWasteBalance }}</div>
                </div>
                <div class="text-4xl opacity-80">♻️</div>
            </div>
            <a href="{{ route('warga.waste-bank.index') }}"
                class="mt-4 inline-flex items-center text-sm text-emerald-100 hover:text-white">
                Lihat Detail
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Upcoming Events -->
        <div class="stat-card">
            <div class="stat-card-icon bg-amber-100 text-amber-600">
                📅
            </div>
            <div class="stat-card-value">{{ $upcomingEventsCount }}</div>
            <div class="stat-card-label">Kegiatan Mendatang</div>
        </div>

        <!-- RT Balance -->
        @if($rtFinance)
            <div class="stat-card">
                <div class="stat-card-icon bg-teal-100 text-teal-600">
                    💰
                </div>
                <div class="stat-card-value text-lg">{{ $rtFinance['formatted_balance'] }}</div>
                <div class="stat-card-label">Saldo {{ $rtFinance['name'] }}</div>
            </div>
        @else
            <div class="stat-card">
                <div class="stat-card-icon bg-teal-100 text-teal-600">
                    💰
                </div>
                <div class="stat-card-value text-lg">{{ $formattedBalance }}</div>
                <div class="stat-card-label">Total Saldo RT</div>
            </div>
        @endif

        <!-- Warga Count -->
        <div class="stat-card">
            <div class="stat-card-icon bg-blue-100 text-blue-600">
                👥
            </div>
            <div class="stat-card-value">{{ $rtResidentCount ?: $totalActiveResidents }}</div>
            <div class="stat-card-label">{{ $user->rt ? 'Warga ' . $user->rt->name : 'Total Warga' }}</div>
        </div>
    </div>

    <!-- Bank Sampah Stats -->
    <div class="card mb-8">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Statistik Bank Sampah Saya</h3>
            <a href="{{ route('warga.waste-bank.history') }}" class="text-sm text-green-600 hover:text-green-700">
                Lihat Riwayat →
            </a>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-3 gap-6 text-center">
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ $wasteStats['total_deposits'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Total Setoran</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($wasteStats['total_weight'], 1) }} kg
                    </div>
                    <div class="text-sm text-gray-500 mt-1">Total Berat</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-emerald-600">{{ $wasteStats['formatted_earned'] }}</div>
                    <div class="text-sm text-gray-500 mt-1">Total Pendapatan</div>
                </div>
            </div>

            @if($recentDeposits->count() > 0)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Setoran Terakhir</h4>
                    <div class="space-y-2">
                        @foreach($recentDeposits as $deposit)
                            <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">{{ $deposit->wasteType->icon }}</span>
                                    <div>
                                        <div class="font-medium text-sm text-gray-900">{{ $deposit->wasteType->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $deposit->deposit_date->format('d M Y') }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold text-sm text-gray-900">{{ $deposit->formatted_weight }}</div>
                                    <div class="text-xs text-emerald-600">+{{ $deposit->formatted_amount }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Events -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Kegiatan Mendatang</h3>
                <a href="{{ route('warga.events.index') }}" class="text-sm text-green-600 hover:text-green-700">
                    Lihat Semua →
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($upcomingEvents as $event)
                    <a href="{{ route('warga.events.show', $event) }}"
                        class="block px-6 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ $event->title }}</div>
                                <div class="text-sm text-gray-500 mt-1">
                                    📆 {{ $event->formatted_date }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    ⏰ {{ $event->formatted_time }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    📍 {{ $event->location }}
                                </div>
                            </div>
                            <span class="{{ $event->status->badgeClass() }}">
                                {{ $event->status->label() }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <div class="text-4xl mb-2">📅</div>
                        <p>Belum ada kegiatan yang dijadwalkan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Finance Summary -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Keuangan RT</h3>
                <a href="{{ route('warga.finance.index') }}" class="text-sm text-green-600 hover:text-green-700">
                    Lihat Detail →
                </a>
            </div>
            <div class="card-body p-0">
                @foreach($categories as $category)
                    <a href="{{ route('warga.finance.category', $category) }}"
                        class="block px-6 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg
                                                @if($category->color === 'teal') bg-teal-100
                                                @elseif($category->color === 'green') bg-green-100
                                                @elseif($category->color === 'purple') bg-purple-100
                                                @elseif($category->color === 'blue') bg-blue-100
                                                @elseif($category->color === 'orange') bg-orange-100
                                                @elseif($category->color === 'emerald') bg-emerald-100
                                                @else bg-gray-100
                                                @endif
                                            ">
                                    {{ $category->icon }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $category->name }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-gray-900">{{ $category->formatted_balance }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="card-footer bg-gray-50">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">Total Saldo</span>
                    <span class="font-bold text-lg text-gray-900">{{ $formattedBalance }}</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.warga>