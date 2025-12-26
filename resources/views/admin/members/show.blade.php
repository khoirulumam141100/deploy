<x-layouts.admin :title="'Detail Anggota'" :header="'Detail Anggota'">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.members.index') }}" class="btn-secondary">
            ← Kembali
        </a>
        <div class="flex gap-3">
            <a href="{{ route('admin.members.edit', $member) }}" class="btn-primary">
                ✏️ Edit
            </a>
            <form action="{{ route('admin.members.destroy', $member) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    🗑️ Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-body text-center">
                    <div
                        class="w-24 h-24 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-3xl mx-auto mb-4">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $member->name }}</h2>
                    <p class="text-gray-500">{{ $member->email }}</p>

                    <div class="mt-4">
                        <span class="{{ $member->status->badgeClass() }} text-sm">
                            {{ $member->status->label() }}
                        </span>
                    </div>

                    @if($member->isPending())
                        <div class="mt-6 flex gap-3">
                            <form action="{{ route('admin.members.approve', $member) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="btn-success w-full">
                                    ✓ Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.members.reject', $member) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="btn-danger w-full">
                                    ✕ Tolak
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Informasi Lengkap</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm text-gray-500">Nama Lengkap</label>
                            <p class="font-medium text-gray-900">{{ $member->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <p class="font-medium text-gray-900">{{ $member->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">No. Telepon</label>
                            <p class="font-medium text-gray-900">{{ $member->phone }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Jenis Kelamin</label>
                            <p class="font-medium text-gray-900">{{ $member->gender?->label() ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Tanggal Lahir</label>
                            <p class="font-medium text-gray-900">{{ $member->birth_date?->format('d F Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Usia</label>
                            <p class="font-medium text-gray-900">{{ $member->age ?? '-' }} tahun</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm text-gray-500">Alamat</label>
                            <p class="font-medium text-gray-900">{{ $member->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membership Info -->
            <div class="card mt-6">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Status Keanggotaan</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="text-sm text-gray-500">Status</label>
                            <p class="mt-1">
                                <span class="{{ $member->status->badgeClass() }}">
                                    {{ $member->status->label() }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Terdaftar Pada</label>
                            <p class="font-medium text-gray-900">{{ $member->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Bergabung Pada</label>
                            <p class="font-medium text-gray-900">{{ $member->joined_at?->format('d F Y') ?? '-' }}</p>
                        </div>
                    </div>

                    @if($member->rejection_reason)
                        <div class="mt-6 p-4 bg-red-50 rounded-lg border border-red-200">
                            <label class="text-sm text-red-600 font-medium">Alasan Penolakan:</label>
                            <p class="text-red-800 mt-1">{{ $member->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>