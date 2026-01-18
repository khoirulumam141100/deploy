<x-layouts.admin :title="'Detail Warga'" :header="'Detail Warga'">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('admin.residents.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            ← Kembali ke Daftar Warga
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-body">
                    <div class="flex items-start gap-6">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl flex items-center justify-center text-white text-3xl font-bold">
                            {{ strtoupper(substr($resident->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $resident->name }}</h2>
                                    <p class="text-gray-500 mt-1">
                                        {{ $resident->rt?->full_name ?? 'RT/RW tidak ditentukan' }}
                                    </p>
                                </div>
                                <span class="{{ $resident->status->badgeClass() }} text-base">
                                    {{ $resident->status->label() }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <div class="text-sm text-gray-500">Email</div>
                                    <div class="font-medium">{{ $resident->email }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Telepon</div>
                                    <div class="font-medium">{{ $resident->phone }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">NIK</div>
                                    <div class="font-medium">{{ $resident->nik ?? '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Jenis Kelamin</div>
                                    <div class="font-medium">{{ $resident->gender?->label() ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Informasi Pribadi</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <div class="text-sm text-gray-500">Tanggal Lahir</div>
                            <div class="font-medium">{{ $resident->birth_date?->format('d F Y') ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Usia</div>
                            <div class="font-medium">{{ $resident->age ?? '-' }} tahun</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Status Tempat Tinggal</div>
                            <div class="font-medium">
                                @if($resident->residence_status)
                                    <span class="{{ $resident->residence_status->badgeClass() }}">
                                        {{ $resident->residence_status->label() }}
                                    </span>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Pekerjaan</div>
                            <div class="font-medium">{{ $resident->occupation ?? '-' }}</div>
                        </div>
                        <div class="col-span-2">
                            <div class="text-sm text-gray-500">Alamat Lengkap</div>
                            <div class="font-medium">{{ $resident->address }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank Sampah -->
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Riwayat Bank Sampah</h3>
                    <div class="text-lg font-bold text-emerald-600">
                        Saldo: Rp {{ number_format($resident->waste_balance, 0, ',', '.') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-3 gap-4 text-center mb-6">
                        <div class="bg-emerald-50 rounded-xl p-4">
                            <div class="text-2xl font-bold text-emerald-600">{{ $wasteStats['total_deposits'] }}</div>
                            <div class="text-sm text-gray-500">Total Setoran</div>
                        </div>
                        <div class="bg-emerald-50 rounded-xl p-4">
                            <div class="text-2xl font-bold text-emerald-600">
                                {{ number_format($wasteStats['total_weight'], 1) }} kg
                            </div>
                            <div class="text-sm text-gray-500">Total Berat</div>
                        </div>
                        <div class="bg-emerald-50 rounded-xl p-4">
                            <div class="text-2xl font-bold text-emerald-600">{{ $wasteStats['formatted_earned'] }}</div>
                            <div class="text-sm text-gray-500">Total Diperoleh</div>
                        </div>
                    </div>

                    @if($recentDeposits->count() > 0)
                        <h4 class="font-medium text-gray-700 mb-3">Setoran Terakhir</h4>
                        <div class="space-y-2">
                            @foreach($recentDeposits as $deposit)
                                <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="font-medium text-sm">{{ $deposit->wasteType->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $deposit->deposit_date->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-medium text-sm">{{ $deposit->formatted_weight }}</div>
                                        <div class="text-xs text-emerald-600">+{{ $deposit->formatted_amount }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-500">
                            <p>Belum ada setoran sampah</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Aksi</h3>
                </div>
                <div class="card-body space-y-3">
                    <a href="{{ route('admin.residents.edit', $resident) }}" class="btn-primary w-full text-center">
                        ✏️ Edit Data Warga
                    </a>

                    @if(!$resident->isPending() && !$resident->isActive())
                        <form method="POST" action="{{ route('admin.residents.approve', $resident) }}"
                            onsubmit="return confirm('Aktifkan kembali akun {{ $resident->name }}?')">
                            @csrf
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-sm mt-3"
                                style="background-color: #2563eb; color: white;">
                                Aktifkan Akun
                            </button>
                        </form>
                    @endif

                    @if($resident->isPending())
                        <form method="POST" action="{{ route('admin.residents.approve', $resident) }}"
                            onsubmit="return confirm('Setujui pendaftaran {{ $resident->name }}?')">
                            @csrf
                            <button type="submit" class="btn w-full bg-green-500 text-white hover:bg-green-600">
                                ✓ Setujui Pendaftaran
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.residents.reject', $resident) }}"
                            onsubmit="return confirm('Tolak pendaftaran {{ $resident->name }}?')">
                            @csrf
                            <button type="submit" class="btn w-full bg-red-500 text-white hover:bg-red-600">
                                ✕ Tolak Pendaftaran
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.residents.destroy', $resident) }}"
                        onsubmit="return confirm('PERINGATAN: Hapus data warga {{ $resident->name }}? Tindakan ini tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-outline w-full text-red-600 border-red-300 hover:bg-red-50">
                            🗑️ Hapus Warga
                        </button>
                    </form>
                </div>
            </div>

            <!-- Registration Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Info Pendaftaran</h3>
                </div>
                <div class="card-body space-y-3">
                    <div>
                        <div class="text-sm text-gray-500">Terdaftar pada</div>
                        <div class="font-medium">{{ $resident->created_at->format('d F Y H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Terakhir diupdate</div>
                        <div class="font-medium">{{ $resident->updated_at->format('d F Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>