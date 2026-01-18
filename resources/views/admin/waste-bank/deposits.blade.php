<x-layouts.admin :title="'Daftar Setoran'" :header="'Daftar Setoran Sampah'">
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-sm text-gray-500">Total Setoran</div>
            <div class="text-2xl font-bold text-gray-900">{{ $summary['total_deposits'] }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-sm text-gray-500">Total Berat</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($summary['total_weight'], 1) }} kg</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-sm text-gray-500">Total Nilai</div>
            <div class="text-2xl font-bold text-emerald-600">{{ $summary['formatted_value'] }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <a href="{{ route('admin.waste-bank.deposits.create') }}" class="btn-primary w-full text-center">
                Catat Setoran Baru
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.waste-bank.deposits') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="form-label">Warga</label>
                    <select name="user_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Warga</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Jenis Sampah</label>
                    <select name="waste_type_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        @foreach($wasteTypes as $type)
                            <option value="{{ $type->id }}" {{ request('waste_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="from" class="form-input" value="{{ request('from') }}"
                        onchange="this.form.submit()">
                </div>
                <div>
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="to" class="form-input" value="{{ request('to') }}"
                        onchange="this.form.submit()">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="btn-primary flex-1">🔍 Filter</button>
                    <a href="{{ route('admin.waste-bank.deposits') }}" class="btn-outline">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Deposits Table -->
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
                            <th>Warga</th>
                            <th>RT/RW</th>
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
                                <td>{{ $deposit->deposit_date->format('d M Y') }}</td>
                                <td>
                                    <div class="font-medium text-gray-900">{{ $deposit->user->name }}</div>
                                </td>
                                <td class="text-gray-500">{{ $deposit->user->rt?->full_name ?? '-' }}</td>
                                <td>
                                    <span class="inline-flex items-center gap-1">
                                        {{ $deposit->wasteType->name }}
                                    </span>
                                </td>
                                <td class="text-right font-medium">{{ $deposit->formatted_weight }}</td>
                                <td class="text-right text-gray-500">Rp
                                    {{ number_format($deposit->price_per_kg, 0, ',', '.') }}
                                </td>
                                <td class="text-right font-semibold text-emerald-600">{{ $deposit->formatted_amount }}</td>
                                <td class="text-gray-500 text-sm max-w-xs truncate">{{ $deposit->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 text-gray-500">
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
        <a href="{{ route('admin.waste-bank.index') }}" class="btn-outline">
            Kembali ke Bank Sampah
        </a>
    </div>
</x-layouts.admin>