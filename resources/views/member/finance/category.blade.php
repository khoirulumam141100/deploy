<x-layouts.member :title="$category->name" :header="$category->name">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('member.finance.index') }}" class="btn-secondary">
                ← Kembali
            </a>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center text-2xl
                    @if($category->color === 'teal') bg-teal-100
                    @elseif($category->color === 'green') bg-green-100
                    @elseif($category->color === 'purple') bg-purple-100
                    @elseif($category->color === 'yellow') bg-yellow-100
                    @else bg-gray-100
                    @endif
                ">
                    {{ $category->icon }}
                </div>
                <p class="text-gray-500 text-sm">{{ $category->description }}</p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stat-card">
            <div class="stat-card-icon bg-green-100 text-green-600">📈</div>
            <div class="stat-card-value text-green-600">{{ $category->formatted_income }}</div>
            <div class="stat-card-label">Total Pemasukan</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon bg-red-100 text-red-600">📉</div>
            <div class="stat-card-value text-red-600">{{ $category->formatted_expense }}</div>
            <div class="stat-card-label">Total Pengeluaran</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon bg-primary-100 text-primary-600">💰</div>
            <div class="stat-card-value">{{ $category->formatted_balance }}</div>
            <div class="stat-card-label">Saldo Saat Ini</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('member.finance.category', $category) }}"
                class="flex flex-col sm:flex-row gap-4">
                <div>
                    <label class="text-xs text-gray-500 block mb-1">Dari Tanggal</label>
                    <input type="date" name="from" id="dateFrom" value="{{ request('from') }}" class="form-input">
                </div>
                <div>
                    <label class="text-xs text-gray-500 block mb-1">Sampai Tanggal</label>
                    <input type="date" name="to" id="dateTo" value="{{ request('to') }}" class="form-input">
                </div>
                <div class="flex items-end gap-2">
                    @if(request('from') || request('to'))
                        <a href="{{ route('member.finance.category', $category) }}" class="btn-secondary">
                            ✕ Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const filterForm = document.getElementById('filterForm');
            const dateFrom = document.getElementById('dateFrom');
            const dateTo = document.getElementById('dateTo');

            dateFrom?.addEventListener('change', () => filterForm.submit());
            dateTo?.addEventListener('change', () => filterForm.submit());
        </script>
    @endpush

    <!-- Transactions List -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-gray-900">Riwayat Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $transaction->transaction_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $transaction->description }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="{{ $transaction->type->badgeClass() }}">
                                    {{ $transaction->type->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span
                                    class="font-semibold {{ $transaction->type->value === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type->value === 'income' ? '+' : '-' }}
                                    {{ $transaction->formatted_amount_plain }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="text-4xl mb-2">📋</div>
                                <p>Belum ada transaksi di kategori ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-layouts.member>