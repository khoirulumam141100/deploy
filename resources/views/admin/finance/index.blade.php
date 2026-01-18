<x-layouts.admin :title="'Keuangan'" :header="'Manajemen Keuangan'">
    <!-- Page Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-gray-600">Kelola keuangan Dusun Kauman, Desa Deras</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.finance.report') }}" target="_blank" class="btn-outline flex items-center gap-2">
                🖨️ Cetak Laporan
            </a>
            <a href="{{ route('admin.transactions.create') }}" class="btn-primary flex items-center gap-2">
                <span>+</span>
                <span>Tambah Transaksi</span>
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.finance.index') }}" id="filterForm"
                class="flex flex-wrap items-end gap-4">
                <!-- RW Filter -->
                <div class="flex-1 min-w-[200px]">
                    <label for="rw_id" class="form-label">Filter RW</label>
                    <select name="rw_id" id="rw_id" class="form-select"
                        onchange="document.getElementById('rt_select').value=''; this.form.submit();">
                        <option value="">Semua RW</option>
                        @foreach($rws as $rw)
                            <option value="{{ $rw->id }}" {{ $selectedRwId == $rw->id ? 'selected' : '' }}>
                                {{ $rw->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- RT Filter -->
                <div class="flex-1 min-w-[200px]">
                    <label for="rt_select" class="form-label">Filter RT</label>
                    <select name="rt_id" id="rt_select" class="form-select" onchange="this.form.submit();" {{ !$selectedRwId ? 'disabled' : '' }}>
                        <option value="">{{ $selectedRwId ? 'Semua RT' : 'Pilih RW dulu' }}</option>
                        @foreach($rts as $rt)
                            @if(!$selectedRwId || $rt->rw_id == $selectedRwId)
                                <option value="{{ $rt->id }}" {{ $selectedRtId == $rt->id ? 'selected' : '' }}>
                                    {{ $rt->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Reset Button -->
                @if($selectedRtId || $selectedRwId)
                    <a href="{{ route('admin.finance.index') }}" class="btn-outline">
                        Reset Filter
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach($categoryBreakdown as $category)
            <a href="{{ route('admin.finance.category', ['category' => $category['slug']]) }}{{ $selectedRtId ? '?rt_id=' . $selectedRtId : '' }}"
                class="stat-card hover:shadow-lg transition-shadow group">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center text-2xl
                                    @if($category['color'] === 'teal') bg-teal-100
                                    @elseif($category['color'] === 'green') bg-green-100
                                    @elseif($category['color'] === 'purple') bg-purple-100
                                    @elseif($category['color'] === 'yellow') bg-yellow-100
                                    @else bg-gray-100
                                    @endif
                                ">
                        {{ $category['icon'] }}
                    </div>
                    <span class="text-gray-400 group-hover:text-primary-600 transition-colors">→</span>
                </div>
                <div class="mt-4">
                    <div class="text-sm text-gray-500">{{ $category['name'] }}</div>
                    <div class="text-xl font-bold text-gray-900 mt-1">{{ $category['formatted_balance'] }}</div>
                    <div class="text-xs text-gray-400 mt-1">
                        {{ $category['transaction_count'] }} transaksi
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Total Balance -->
    <div class="card bg-gradient-to-r from-primary-600 to-primary-700 text-white mb-6">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-primary-100">
                        Total Saldo
                        @if($selectedRtId)
                            {{ $rts->firstWhere('id', $selectedRtId)?->full_name ?? '' }}
                        @elseif($selectedRwId)
                            {{ $rws->firstWhere('id', $selectedRwId)?->name ?? '' }}
                        @else
                            Keseluruhan
                        @endif
                    </p>
                    <h2 class="text-3xl font-bold mt-1">Rp {{ number_format($totalBalance, 0, ',', '.') }}</h2>
                </div>
                <div class="text-6xl opacity-20">💰</div>
            </div>
        </div>
    </div>

    <!-- RT Breakdown (when showing all or RW filter) -->
    @if(!$selectedRtId && count($rtBreakdown) > 0)
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Saldo per RT</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">RT</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Pemasukan</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Pengeluaran</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($rtBreakdown as $rt)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $rt['name'] }}</td>
                                <td class="px-6 py-4 text-sm text-right text-green-600">
                                    Rp {{ number_format($rt['income'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-red-600">
                                    Rp {{ number_format($rt['expense'], 0, ',', '.') }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-right font-semibold {{ $rt['balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $rt['formatted_balance'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Recent Transactions -->
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Transaksi Terkini</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">RT</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $transaction->transaction_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $transaction->rt?->full_name ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">{{ $transaction->category->icon }}</span>
                                    <span class="text-sm text-gray-900">{{ $transaction->category->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ Str::limit($transaction->description, 40) }}
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
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.transactions.edit', $transaction) }}"
                                        class="text-gray-500 hover:text-yellow-600" title="Edit">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-600" title="Hapus">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="text-4xl mb-2">📊</div>
                                <p>Belum ada transaksi</p>
                                <a href="{{ route('admin.transactions.create') }}" class="btn-primary mt-4 inline-flex">
                                    + Tambah Transaksi Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>