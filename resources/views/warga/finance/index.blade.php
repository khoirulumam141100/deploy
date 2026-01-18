<x-layouts.warga :title="'Keuangan RT'" :header="'Transparansi Keuangan RT'">
    <!-- Summary -->
    <div class="card mb-6 bg-gradient-to-r from-teal-500 to-green-600 text-white">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-teal-100">Total Saldo Kas {{ $user->rt?->name ?? 'RT' }}</div>
                    <div class="text-4xl font-bold mt-2">{{ $formattedBalance }}</div>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-6 text-sm">
                <div>
                    <span class="text-teal-100">Pemasukan:</span>
                    <span class="font-semibold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="text-teal-100">Pengeluaran:</span>
                    <span class="font-semibold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @foreach($categories as $category)
            <a href="{{ route('warga.finance.category', $category) }}"
                class="card p-4 hover:shadow-lg transition-shadow border-2 border-transparent hover:border-green-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl
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
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $category->name }}</h3>
                        <p class="text-lg font-bold text-gray-700">{{ $category->formatted_balance }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Recent Transactions -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-gray-900">Transaksi Terbaru</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $transaction)
                            <tr>
                                <td class="text-gray-500">{{ $transaction->transaction_date->format('d M Y') }}</td>
                                <td>
                                    {{ $transaction->category->name }}
                                </td>
                                <td>{{ $transaction->description }}</td>
                                <td
                                    class="text-right font-semibold {{ $transaction->type->value === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->formatted_amount }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-500">
                                    <p>Belum ada transaksi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Info Notice -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <div class="text-sm text-blue-800">
                <strong>Tentang Transparansi Keuangan:</strong> Halaman ini menampilkan ringkasan keuangan
                {{ $user->rt?->full_name ?? 'RT' }} Anda.
                Data keuangan dikelola oleh pengurus RT/RW dan diperbarui secara berkala untuk menjaga transparansi
                kepada seluruh warga.
            </div>
        </div>
    </div>
</x-layouts.warga>