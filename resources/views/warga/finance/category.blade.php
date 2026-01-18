<x-layouts.warga :title="$category->name" :header="$category->name">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('warga.finance.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            Kembali ke Ringkasan Keuangan
        </a>
    </div>

    <!-- Category Summary -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl
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
                    <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                    <p class="text-gray-500">{{ $category->description }}</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200">
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-500">Total Pemasukan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-500">Total Pengeluaran</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $category->formatted_balance }}</div>
                    <div class="text-sm text-gray-500">Saldo</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="{{ route('warga.finance.category', $category) }}"
                class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="form-label">Jenis</label>
                    <select name="type" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Bulan</label>
                    <input type="month" name="month" class="form-input" value="{{ request('month') }}"
                        onchange="this.form.submit()">
                </div>
                @if(request('type') || request('month'))
                    <a href="{{ route('warga.finance.category', $category) }}"
                        class="btn-outline h-[42px] flex items-center px-4">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Transactions -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-gray-900">Daftar Transaksi</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jenis</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="text-gray-500">{{ $transaction->transaction_date->format('d M Y') }}</td>
                                <td>{{ $transaction->description }}</td>
                                <td>
                                    @if($transaction->type->value === 'income')
                                        <span class="badge-success">Pemasukan</span>
                                    @else
                                        <span class="badge-danger">Pengeluaran</span>
                                    @endif
                                </td>
                                <td
                                    class="text-right font-semibold {{ $transaction->type->value === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->formatted_amount }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-500">
                                    <p>Tidak ada transaksi dalam kategori ini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($transactions->hasPages())
            <div class="card-footer">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-layouts.warga>