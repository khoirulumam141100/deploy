<x-layouts.admin :title="'Data Warga'" :header="'Data Warga'">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-sm text-gray-500">Total Warga</div>
            <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-green-50 rounded-xl border border-green-200 p-4">
            <div class="text-sm text-green-600">Aktif</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
        </div>
        <div class="bg-amber-50 rounded-xl border border-amber-200 p-4">
            <a href="{{ route('admin.residents.pending') }}" class="block">
                <div class="text-sm text-amber-600">Menunggu Persetujuan</div>
                <div class="text-2xl font-bold text-amber-600">{{ $stats['pending'] }}</div>
            </a>
        </div>
        <div class="bg-red-50 rounded-xl border border-red-200 p-4">
            <div class="text-sm text-red-600">Ditolak/Nonaktif</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
        </div>
    </div>

    <!-- Filter & Actions -->
    <div class="card mb-6">
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('admin.residents.index') }}"
                class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                <div>
                    <label class="form-label">Cari</label>
                    <div class="relative">
                        <input type="text" name="search" id="searchInput" class="form-input" style="padding-left: 2.5rem;"
                            placeholder="Nama, email, NIK..." value="{{ request('search') }}">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="form-label">RW</label>
                    <select name="rw_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua RW</option>
                        @foreach($rws as $rw)
                            <option value="{{ $rw->id }}" {{ request('rw_id') == $rw->id ? 'selected' : '' }}>
                                {{ $rw->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">RT</label>
                    <select name="rt_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua RT</option>
                        @foreach($rts as $rt)
                            <option value="{{ $rt->id }}" {{ request('rt_id') == $rt->id ? 'selected' : '' }}>
                                {{ $rt->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
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
                    <label class="form-label">Status Tinggal</label>
                    <select name="residence_status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        @foreach($residenceStatuses as $status)
                            <option value="{{ $status->value }}" {{ request('residence_status') == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    @if(request('search') || request('rw_id') || request('rt_id') || request('status') || request('residence_status'))
                        <a href="{{ route('admin.residents.index') }}" class="btn-outline w-full text-center">Reset Filter</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Debounce search input
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        });
    </script>
    @endpush

    <!-- Actions -->
    <div class="flex justify-between items-center mb-4">
        <div class="text-sm text-gray-500">
            Menampilkan {{ $residents->count() }} dari {{ $residents->total() }} warga
        </div>
        <a href="{{ route('admin.residents.create') }}" class="btn-primary">
            ➕ Tambah Warga Baru
        </a>
    </div>

    <!-- Residents Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Warga</th>
                            <th>RT/RW</th>
                            <th>Kontak</th>
                            <th>Status Tinggal</th>
                            <th>Bank Sampah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($residents as $resident)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white font-medium">
                                            {{ strtoupper(substr($resident->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $resident->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $resident->nik ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-medium text-gray-900">{{ $resident->rt?->name ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $resident->rt?->rw?->name ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $resident->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $resident->phone }}</div>
                                </td>
                                <td>
                                    @if($resident->residence_status)
                                        <span class="{{ $resident->residence_status->badgeClass() }}">
                                            {{ $resident->residence_status->icon() }} {{ $resident->residence_status->label() }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-medium text-emerald-600">Rp
                                        {{ number_format($resident->waste_balance, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    <span class="{{ $resident->status->badgeClass() }}">
                                        {{ $resident->status->label() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.residents.show', $resident) }}"
                                            class="text-blue-600 hover:text-blue-800" title="Detail">
                                            👁️
                                        </a>
                                        <a href="{{ route('admin.residents.edit', $resident) }}"
                                            class="text-green-600 hover:text-green-800" title="Edit">
                                            ✏️
                                        </a>
                                        @if($resident->isPending())
                                            <form method="POST" action="{{ route('admin.residents.approve', $resident) }}"
                                                class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-800"
                                                    title="Setujui">
                                                    ✓
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.residents.reject', $resident) }}"
                                                class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-800" title="Tolak">
                                                    ✕
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-500">
                                    <div class="text-4xl mb-2">👥</div>
                                    <p>Belum ada data warga</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($residents->hasPages())
            <div class="card-footer">
                {{ $residents->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>