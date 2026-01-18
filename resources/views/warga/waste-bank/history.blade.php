<x-layouts.warga :title="'Riwayat Setoran'" :header="'Riwayat Setoran Sampah'">
    <!-- Summary -->
    <div class="card mb-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
        <div class="card-body">
            <div class="grid grid-cols-3 gap-6 text-center">
                <div>
                    <div class="text-emerald-100 text-sm">Total Setoran</div>
                    <div class="text-2xl font-bold mt-1">{{ $summary['total_deposits'] }}</div>
                </div>
                <div>
                    <div class="text-emerald-100 text-sm">Total Berat</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($summary['total_weight'], 1) }} kg</div>
                </div>
                <div>
                    <div class="text-emerald-100 text-sm">Total Pendapatan</div>
                    <div class="text-2xl font-bold mt-1">Rp {{ number_format($summary['total_earned'], 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="{{ route('warga.waste-bank.history') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Jenis Sampah</label>
                    <select name="waste_type_id" class="form-select">
                        <option value="">Semua Jenis</option>
                        @foreach($wasteTypes as $type)
                            <option value="{{ $type->id }}" {{ request('waste_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->icon }} {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="from" class="form-input" value="{{ request('from') }}">
                </div>
                <div>
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="to" class="form-input" value="{{ request('to') }}">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="btn-primary flex-1">
                        🔍 Filter
                    </button>
                    <a href="{{ route('warga.waste-bank.history') }}" class="btn-outline">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Deposits List -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-gray-900">Daftar Setoran</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Sampah</th>
                            <th class="text-right">Berat</th>
                            <th class="text-right">Harga/kg</th>
                            <th class="text-right">Total</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deposits as $deposit)
                            <tr>
                                <td>
                                    <div class="font-medium text-gray-900">{{ $deposit->deposit_date->format('d M Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xl">{{ $deposit->wasteType->icon }}</span>
                                        <span>{{ $deposit->wasteType->name }}</span>
                                    </div>
                                </td>
                                <td class="text-right font-medium">{{ $deposit->formatted_weight }}</td>
                                <td class="text-right text-gray-500">Rp
                                    {{ number_format($deposit->price_per_kg, 0, ',', '.') }}</td>
                                <td class="text-right font-semibold text-emerald-600">{{ $deposit->formatted_amount }}</td>
                                <td class="text-gray-500 text-sm">{{ $deposit->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">
                                    <div class="text-4xl mb-2">📦</div>
                                    <p>Belum ada setoran sampah</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($deposits->hasPages())
            <div class="card-footer">
                {{ $deposits->links() }}
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('warga.waste-bank.index') }}" class="btn-outline">
            ← Kembali ke Bank Sampah
        </a>
    </div>
</x-layouts.warga>