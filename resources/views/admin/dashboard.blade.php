<x-layouts.admin :title="'Dashboard'" :header="'Dashboard'">
    <!-- RT/RW Filter -->
    <div class="mb-6">
        <form id="filterForm" method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-4 flex-wrap">
            <div class="flex items-center gap-3">
                <label class="text-sm font-medium text-gray-700">Filter:</label>
                <select name="rw_id" class="form-select w-auto" onchange="document.getElementById('rt_select').value=''; this.form.submit();">
                    <option value="">Semua RW</option>
                    @foreach($rws as $rw)
                        <option value="{{ $rw->id }}" {{ $selectedRwId == $rw->id ? 'selected' : '' }}>
                            {{ $rw->name }}
                        </option>
                    @endforeach
                </select>
                <select name="rt_id" id="rt_select" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="">{{ $selectedRwId ? 'Semua RT' : 'Pilih RW dulu' }}</option>
                    @foreach($rts as $rt)
                        <option value="{{ $rt->id }}" {{ $selectedRtId == $rt->id ? 'selected' : '' }}>
                            {{ $selectedRwId ? $rt->name : $rt->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if($selectedRtId || $selectedRwId)
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 hover:underline">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Residents -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div class="stat-card-icon bg-green-100 text-green-600">
                    👥
                </div>
                @if($stats['pending_residents'] > 0)
                    <a href="{{ route('admin.residents.pending') }}" class="badge-warning">{{ $stats['pending_residents'] }}
                        pending</a>
                @endif
            </div>
            <div class="stat-card-value">{{ $stats['total_residents'] }}</div>
            <div class="stat-card-label">Warga Aktif</div>
        </div>

        <!-- Total Balance -->
        <div class="stat-card">
            <div class="stat-card-icon bg-teal-100 text-teal-600">
                💰
            </div>
            <div class="stat-card-value text-xl">{{ $stats['formatted_balance'] }}</div>
            <div class="stat-card-label">Total Saldo Kas</div>
        </div>

        <!-- Bank Sampah -->
        <div class="stat-card bg-gradient-to-br from-emerald-500 to-teal-600 text-white">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-2xl">
                    ♻️
                </div>
            </div>
            <div class="text-2xl font-bold mt-2">{{ $wasteStats['formatted_value'] }}</div>
            <div class="text-emerald-100 text-sm">{{ number_format($wasteStats['total_weight'], 0) }} kg |
                {{ $wasteStats['total_deposits'] }} setoran</div>
        </div>

        <!-- Events This Month -->
        <div class="stat-card">
            <div class="stat-card-icon bg-amber-100 text-amber-600">
                📅
            </div>
            <div class="stat-card-value">{{ $stats['events_this_month'] }}</div>
            <div class="stat-card-label">Kegiatan Bulan Ini</div>
        </div>
    </div>

    <!-- RT Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach($rtStats as $rt)
            <div class="card p-4 hover:shadow-lg transition-shadow cursor-pointer"
                onclick="window.location='{{ route('admin.dashboard', ['rt_id' => $rt['id']]) }}'">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-semibold text-gray-900">{{ $rt['name'] }}</span>
                    <span class="text-sm text-gray-500">{{ $rt['resident_count'] }} warga</span>
                </div>
                <div class="text-lg font-bold text-teal-600">{{ $rt['formatted_balance'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Charts & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Cash Flow Chart -->
        <div class="card lg:col-span-2">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Arus Kas (Tahun {{ date('Y') }})</h3>
            </div>
            <div class="card-body">
                <div class="h-64">
                    <canvas id="cashFlowChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Per Kategori</h3>
            </div>
            <div class="card-body p-0">
                @foreach($categories as $category)
                    <div class="px-4 py-3 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span>{{ $category->icon }}</span>
                                <span class="text-sm text-gray-700">{{ $category->name }}</span>
                            </div>
                            <span class="font-semibold text-sm text-gray-900">{{ $category->formatted_balance }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Pending Approvals -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Menunggu Persetujuan</h3>
                @if($pendingResidents->count() > 0)
                    <a href="{{ route('admin.residents.pending') }}" class="text-sm text-green-600 hover:text-green-700">
                        Lihat Semua →
                    </a>
                @endif
            </div>
            <div class="card-body p-0">
                @forelse($pendingResidents as $resident)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ $resident->name }}</div>
                                <div class="text-sm text-gray-500">{{ $resident->rt?->full_name ?? '-' }} •
                                    {{ $resident->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('admin.residents.approve', $resident) }}">
                                    @csrf
                                    <button type="submit" class="btn-sm bg-green-500 text-white hover:bg-green-600">
                                        ✓
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.residents.reject', $resident) }}">
                                    @csrf
                                    <button type="submit" class="btn-sm bg-red-500 text-white hover:bg-red-600">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <div class="text-4xl mb-2">✅</div>
                        <p>Tidak ada pendaftaran yang menunggu</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Kegiatan Mendatang</h3>
                <a href="{{ route('admin.events.index') }}" class="text-sm text-green-600 hover:text-green-700">
                    Lihat Semua →
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($upcomingEvents as $event)
                    <a href="{{ route('admin.events.show', $event) }}"
                        class="block px-6 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ $event->title }}</div>
                                <div class="text-sm text-gray-500 mt-1">
                                    📆 {{ $event->formatted_date }} • 📍 {{ $event->location }}
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
                        <p>Belum ada kegiatan mendatang</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Waste Deposits -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Setoran Sampah Terbaru</h3>
            <a href="{{ route('admin.waste-bank.deposits') }}" class="text-sm text-green-600 hover:text-green-700">
                Lihat Semua →
            </a>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Warga</th>
                            <th>Jenis</th>
                            <th class="text-right">Berat</th>
                            <th class="text-right">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentDeposits as $deposit)
                            <tr>
                                <td>{{ $deposit->deposit_date->format('d M Y') }}</td>
                                <td>
                                    <div class="font-medium text-gray-900">{{ $deposit->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $deposit->user->rt?->name ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="inline-flex items-center gap-1">
                                        {{ $deposit->wasteType->icon }} {{ $deposit->wasteType->name }}
                                    </span>
                                </td>
                                <td class="text-right font-medium">{{ $deposit->formatted_weight }}</td>
                                <td class="text-right font-semibold text-emerald-600">{{ $deposit->formatted_amount }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    Belum ada setoran sampah
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Cash Flow Chart
                const ctxCashFlow = document.getElementById('cashFlowChart').getContext('2d');
                new Chart(ctxCashFlow, {
                    type: 'line',
                    data: {
                        labels: @json($months),
                        datasets: [
                            {
                                label: 'Pemasukan',
                                data: @json($incomeData),
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Pengeluaran',
                                data: @json($expenseData),
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                tension: 0.3,
                                fill: true
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
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-layouts.admin>