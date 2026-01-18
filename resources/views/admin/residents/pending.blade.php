<x-layouts.admin :title="'Warga Pending'" :header="'Warga Menunggu Persetujuan'">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('admin.residents.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            ← Kembali ke Daftar Warga
        </a>
    </div>

    @if($residents->count() > 0)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
            <div class="flex items-center gap-3">
                <span class="text-2xl">⏳</span>
                <p class="text-amber-800">
                    Terdapat <strong>{{ $residents->count() }}</strong> pendaftaran warga yang menunggu persetujuan Anda.
                </p>
            </div>
        </div>
    @endif

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
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($residents as $resident)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-amber-700 font-medium">
                                            {{ strtoupper(substr($resident->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $resident->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $resident->nik ?? 'NIK belum diisi' }}
                                            </div>
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
                                    <div class="text-sm text-gray-900">{{ $resident->created_at->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $resident->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.residents.show', $resident) }}" class="btn-sm btn-outline"
                                            title="Lihat Detail">
                                            Detail
                                        </a>
                                        <form method="POST" action="{{ route('admin.residents.approve', $resident) }}"
                                            class="inline"
                                            onsubmit="return confirm('Setujui pendaftaran {{ $resident->name }}?')">
                                            @csrf
                                            <button type="submit" class="btn-sm bg-green-500 text-white hover:bg-green-600">
                                                ✓ Setujui
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.residents.reject', $resident) }}"
                                            class="inline"
                                            onsubmit="return confirm('Tolak pendaftaran {{ $resident->name }}?')">
                                            @csrf
                                            <button type="submit" class="btn-sm bg-red-500 text-white hover:bg-red-600">
                                                ✕ Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-gray-500">
                                    <div class="text-5xl mb-3">✅</div>
                                    <p class="text-lg font-medium">Tidak ada pendaftaran yang menunggu</p>
                                    <p class="text-sm mt-1">Semua pendaftaran warga sudah diproses.</p>
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