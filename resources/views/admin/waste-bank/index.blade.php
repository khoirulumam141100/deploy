<x-layouts.admin :title="'Bank Sampah'" :header="'Bank Sampah'">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card p-6 bg-gradient-to-br from-emerald-500 to-teal-600 text-white">
            <div class="text-emerald-100 text-sm">Total Nilai</div>
            <div class="text-3xl font-bold mt-1">{{ $stats['formatted_value'] }}</div>
            <div class="text-emerald-100 text-sm mt-2">{{ $stats['total_deposits'] }} setoran</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon bg-green-100 text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
            </div>
            <div class="stat-card-value">{{ number_format($stats['total_weight'], 1) }} kg</div>
            <div class="stat-card-label">Total Berat</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon bg-blue-100 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="stat-card-value">{{ $stats['active_depositors'] }}</div>
            <div class="stat-card-label">Penabung Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon bg-amber-100 text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-card-value">{{ $stats['pending_redemptions'] }}</div>
            <div class="stat-card-label">Penukaran Pending</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.waste-bank.deposits.create') }}" class="btn-primary">
            Catat Setoran Baru
        </a>
        <a href="{{ route('admin.waste-bank.deposits') }}" class="btn-outline">
            Semua Setoran
        </a>
        <a href="{{ route('admin.waste-bank.types') }}" class="btn-outline">
            Kelola Jenis Sampah
        </a>
        <a href="{{ route('admin.waste-bank.redemptions') }}" class="btn-outline">
            Permintaan Penukaran
            @if($stats['pending_redemptions'] > 0)
                <span class="ml-2 bg-amber-100 text-amber-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $stats['pending_redemptions'] }}
                </span>
            @endif
        </a>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Monthly Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Tren Bulanan ({{ date('Y') }})</h3>
            </div>
            <div class="card-body">
                <div class="h-64">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Waste Type Stats -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Per Jenis Sampah</h3>
            </div>
            <div class="card-body p-0">
                @foreach($wasteTypeStats as $type)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $type['name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $type['formatted_price'] }}/kg •
                                        {{ $type['deposit_count'] }} setoran
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-gray-900">{{ number_format($type['total_weight'], 1) }} kg
                                </div>
                                <div class="text-sm text-emerald-600">{{ $type['formatted_value'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Deposits -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Setoran Terbaru</h3>
                <a href="{{ route('admin.waste-bank.deposits') }}" class="text-sm text-green-600 hover:text-green-700">
                    Lihat Semua →
                </a>
            </div>
            <div class="card-body p-0">
                @foreach($recentDeposits as $deposit)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $deposit->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $deposit->wasteType->name }} •
                                        {{ $deposit->deposit_date->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-medium text-gray-900">{{ $deposit->formatted_weight }}</div>
                                <div class="text-sm text-emerald-600">{{ $deposit->formatted_amount }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Depositors -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Top Penabung</h3>
            </div>
            <div class="card-body p-0">
                @foreach($topDepositors as $index => $depositor)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                            @if($index == 0) bg-yellow-100 text-yellow-700
                                            @elseif($index == 1) bg-gray-100 text-gray-700
                                            @elseif($index == 2) bg-orange-100 text-orange-700
                                            @else bg-gray-50 text-gray-500
                                            @endif
                                        ">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $depositor->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $depositor->rt?->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-emerald-600">Rp
                                    {{ number_format($depositor->waste_deposits_sum_total_amount ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ number_format($depositor->waste_deposits_sum_weight ?? 0, 1) }} kg
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('monthlyChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($months),
                        datasets: [
                            {
                                label: 'Berat (kg)',
                                data: @json($weightData),
                                backgroundColor: 'rgba(16, 185, 129, 0.7)',
                                borderRadius: 4,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Nilai (Rp)',
                                data: @json($valueData),
                                type: 'line',
                                borderColor: '#0d9488',
                                backgroundColor: 'transparent',
                                tension: 0.3,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Berat (kg)'
                                }
                            },
                            y1: {
                                type: 'linear',
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false
                                },
                                title: {
                                    display: true,
                                    text: 'Nilai (Rp)'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-layouts.admin>