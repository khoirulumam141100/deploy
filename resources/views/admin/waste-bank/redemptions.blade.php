<x-layouts.admin :title="'Penukaran Saldo'" :header="'Permintaan Penukaran Saldo'">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-sm text-gray-500">Total Permintaan</div>
            <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-amber-50 rounded-xl border border-amber-200 p-4">
            <div class="text-sm text-amber-600">Menunggu</div>
            <div class="text-2xl font-bold text-amber-600">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-green-50 rounded-xl border border-green-200 p-4">
            <div class="text-sm text-green-600">Disetujui</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</div>
        </div>
        <div class="bg-red-50 rounded-xl border border-red-200 p-4">
            <div class="text-sm text-red-600">Ditolak</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.waste-bank.redemptions') }}"
                class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
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
                @if(request('status') || request('user_id'))
                    <a href="{{ route('admin.waste-bank.redemptions') }}" class="btn-outline text-sm">
                        Reset Filter
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Redemptions Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-gray-900">Daftar Permintaan</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Warga</th>
                            <th>RT/RW</th>
                            <th class="text-right">Jumlah</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($redemptions as $redemption)
                            <tr>
                                <td>{{ $redemption->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="font-medium text-gray-900">{{ $redemption->user->name }}</div>
                                    <div class="text-sm text-gray-500">Saldo: Rp
                                        {{ number_format($redemption->user->waste_balance, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="text-gray-500">{{ $redemption->user->rt?->full_name ?? '-' }}</td>
                                <td class="text-right font-semibold text-gray-900">{{ $redemption->formatted_amount }}</td>
                                <td>
                                    <span class="inline-flex items-center gap-1">
                                        {{ $redemption->redemption_type->label() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="{{ $redemption->status->badgeClass() }}">
                                        {{ $redemption->status->label() }}
                                    </span>
                                </td>
                                <td class="text-gray-500 text-sm max-w-xs truncate">{{ $redemption->notes ?? '-' }}</td>
                                <td>
                                    @if($redemption->status->value === 'pending')
                                        <div class="flex gap-2">
                                            <form method="POST"
                                                action="{{ route('admin.waste-bank.redemptions.process', $redemption) }}"
                                                onsubmit="return confirm('Setujui penukaran ini? Saldo warga akan dipotong.')">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="btn-sm bg-green-500 text-white hover:bg-green-600"
                                                    title="Setujui">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form method="POST"
                                                action="{{ route('admin.waste-bank.redemptions.process', $redemption) }}"
                                                onsubmit="return confirm('Tolak penukaran ini?')">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn-sm bg-red-500 text-white hover:bg-red-600"
                                                    title="Tolak">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 text-gray-500">
                                    <p>Belum ada permintaan penukaran</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($redemptions->hasPages())
            <div class="card-footer">
                {{ $redemptions->links() }}
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