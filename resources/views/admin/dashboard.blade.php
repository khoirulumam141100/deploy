<x-layouts.admin :title="'Dashboard'" :header="'Dashboard'">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Members -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div class="stat-card-icon bg-primary-100 text-primary-600">
                    👥
                </div>
                @if($stats['pending_members'] > 0)
                    <span class="badge-warning">{{ $stats['pending_members'] }} pending</span>
                @endif
            </div>
            <div class="stat-card-value">{{ $stats['total_members'] }}</div>
            <div class="stat-card-label">Anggota Aktif</div>
        </div>

        <!-- Pending Approval -->
        <div class="stat-card">
            <div class="stat-card-icon bg-yellow-100 text-yellow-600">
                ⏳
            </div>
            <div class="stat-card-value">{{ $stats['pending_members'] }}</div>
            <div class="stat-card-label">Menunggu Persetujuan</div>
        </div>

        <!-- Total Balance -->
        <div class="stat-card">
            <div class="stat-card-icon bg-secondary-100 text-secondary-600">
                💰
            </div>
            <div class="stat-card-value text-xl">{{ $stats['formatted_balance'] }}</div>
            <div class="stat-card-label">Total Saldo</div>
        </div>

        <!-- Events This Month -->
        <div class="stat-card">
            <div class="stat-card-icon bg-purple-100 text-purple-600">
                📅
            </div>
            <div class="stat-card-value">{{ $stats['events_this_month'] }}</div>
            <div class="stat-card-label">Kegiatan Bulan Ini</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Cash Flow Chart -->
        <div class="card lg:col-span-2">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Arus Kas (Tahun Ini)</h3>
            </div>
            <div class="card-body">
                <div class="h-64">
                    <canvas id="cashFlowChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Distribution Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Distribusi Transaksi</h3>
            </div>
            <div class="card-body">
                <div class="h-64 flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Register the plugin to all charts if needed, or just specific ones
                // Chart.register(ChartDataLabels);

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
                                borderColor: '#10b981', // green-500
                                backgroundColor: '#10b981',
                                tension: 0.3,
                                fill: false
                            },
                            {
                                label: 'Pengeluaran',
                                data: @json($expenseData),
                                borderColor: '#ef4444', // red-500
                                backgroundColor: '#ef4444',
                                tension: 0.3,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: { position: 'bottom' },
                            datalabels: { display: false }, // Disable stats on line chart
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        let label = context.dataset.label || '';
                                        if (label) { label += ': '; }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return new Intl.NumberFormat('id-ID', { compactDisplay: "short", notation: "compact", style: 'currency', currency: 'IDR' }).format(value);
                                    }
                                }
                            }
                        }
                    }
                });

                // Category Chart
                const ctxCategory = document.getElementById('categoryChart').getContext('2d');
                const categoryData = @json($categoryStats);
                const totalTransactions = categoryData.reduce((acc, curr) => acc + curr.count, 0);

                new Chart(ctxCategory, {
                    type: 'doughnut',
                    plugins: [ChartDataLabels], // Enable plugin specifically here
                    data: {
                        labels: categoryData.map(c => c.name),
                        datasets: [{
                            data: categoryData.map(c => c.count),
                            backgroundColor: [
                                '#16a34a', // primary green-600
                                '#eab308', // secondary yellow-500
                                '#22c55e', // green-500
                                '#ca8a04', // yellow-600
                                '#86efac'  // green-300
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    usePointStyle: true,
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        let label = context.label || '';
                                        let value = context.parsed;
                                        let percentage = totalTransactions > 0 ? ((value / totalTransactions) * 100).toFixed(1) + '%' : '0%';
                                        return label + ': ' + value + ' (' + percentage + ')';
                                    }
                                }
                            },
                            datalabels: {
                                color: '#ffffff',
                                font: {
                                    weight: 'bold',
                                    size: 11
                                },
                                formatter: (value, ctx) => {
                                    if (totalTransactions === 0) return '';
                                    let percentage = ((value / totalTransactions) * 100).toFixed(1) + '%';
                                    // Only show if percentage > 5% to avoid overcrowding
                                    return (value / totalTransactions) > 0.05 ? percentage : '';
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pending Approvals -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Pendaftaran Pending</h3>
                <a href="{{ route('admin.members.pending') }}" class="text-sm text-primary-600 hover:text-primary-700">
                    Lihat Semua →
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($pendingMembers as $member)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0 flex items-center justify-between">
                        <div>
                            <div class="font-medium text-gray-900">{{ $member->name }}</div>
                            <div class="text-sm text-gray-500">{{ $member->email }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $member->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('admin.members.approve', $member) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-success text-xs px-3 py-1">
                                    Setujui
                                </button>
                            </form>
                            <button type="button" onclick="showRejectModal({{ $member->id }}, '{{ $member->name }}')"
                                class="btn-danger text-xs px-3 py-1">
                                Tolak
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <div class="text-4xl mb-2">✓</div>
                        <p>Tidak ada pendaftaran yang menunggu persetujuan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Finance Summary -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Ringkasan Keuangan</h3>
                <a href="{{ route('admin.finance.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                    Lihat Detail →
                </a>
            </div>
            <div class="card-body p-0">
                @foreach($categories as $category)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg
                                                                @if($category->color === 'teal') bg-teal-100
                                                                @elseif($category->color === 'green') bg-green-100
                                                                @elseif($category->color === 'purple') bg-purple-100
                                                                @elseif($category->color === 'yellow') bg-yellow-100
                                                                @else bg-gray-100
                                                                @endif
                                                            ">
                                {{ $category->icon }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $category->name }}</div>
                                <div class="text-xs text-gray-500">{{ $category->transaction_count }} transaksi</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-gray-900">{{ $category->formatted_balance }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">Total Saldo</span>
                    <span class="font-bold text-lg text-gray-900">{{ $stats['formatted_balance'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="card mt-6">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Kegiatan Mendatang</h3>
            <a href="{{ route('admin.events.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                Lihat Semua →
            </a>
        </div>
        <div class="card-body p-0">
            @forelse($upcomingEvents as $event)
                <div class="px-6 py-4 border-b border-gray-100 last:border-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="font-medium text-gray-900">{{ $event->title }}</div>
                            <div class="text-sm text-gray-500 mt-1">
                                📆 {{ $event->formatted_date }} • ⏰ {{ $event->formatted_time }}
                            </div>
                            <div class="text-sm text-gray-500">
                                📍 {{ $event->location }}
                            </div>
                        </div>
                        <span class="{{ $event->status->badgeClass() }}">
                            {{ $event->status->label() }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-500">
                    <div class="text-4xl mb-2">📅</div>
                    <p>Belum ada kegiatan yang dijadwalkan</p>
                    <a href="{{ route('admin.events.create') }}" class="btn-primary mt-4">
                        Tambah Kegiatan
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 animate-fade-in">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tolak Pendaftaran</h3>
                <p class="text-gray-600 mb-4">Tolak pendaftaran <strong id="rejectName"></strong>?</p>

                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Alasan Penolakan (opsional)</label>
                        <textarea name="reason" rows="3" class="form-textarea"
                            placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="hideRejectModal()" class="btn-secondary flex-1">
                            Batal
                        </button>
                        <button type="submit" class="btn-danger flex-1">
                            Tolak Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showRejectModal(id, name) {
                document.getElementById('rejectName').textContent = name;
                document.getElementById('rejectForm').action = `/admin/members/${id}/reject`;
                document.getElementById('rejectModal').classList.remove('hidden');
            }

            function hideRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
            }

            // Close on escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') hideRejectModal();
            });

            // Close on backdrop click
            document.getElementById('rejectModal')?.addEventListener('click', function (e) {
                if (e.target === this) hideRejectModal();
            });
        </script>
    @endpush
</x-layouts.admin>