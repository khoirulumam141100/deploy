<x-layouts.warga :title="'Tukar Saldo'" :header="'Penukaran Saldo Bank Sampah'">
    <!-- Balance Card -->
    <div class="card mb-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-emerald-100">Saldo Tersedia</div>
                    <div class="text-4xl font-bold mt-2">{{ $formattedBalance }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Redemption Form -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Ajukan Penukaran</h3>
            </div>
            <div class="card-body">
                @if($wasteBalance >= 10000)
                    <form method="POST" action="{{ route('warga.waste-bank.redeem.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="amount" class="form-label">Jumlah Penukaran <span
                                    class="text-red-500">*</span></label>
                            <div>
                                <input type="number" id="amount" name="amount"
                                    class="form-input @error('amount') border-red-500 @enderror" min="10000"
                                    max="{{ $wasteBalance }}" step="1000" value="{{ old('amount') }}" 
                                    placeholder="Masukkan jumlah (Rp)" required>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Minimal Rp 10.000, maksimal {{ $formattedBalance }}</p>
                            @error('amount')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="redemption_type" class="form-label">Jenis Penukaran <span
                                    class="text-red-500">*</span></label>
                            <select id="redemption_type" name="redemption_type"
                                class="form-select @error('redemption_type') border-red-500 @enderror" required>
                                <option value="">Pilih jenis penukaran...</option>
                                @foreach($redemptionTypes as $type)
                                    <option value="{{ $type->value }}" {{ old('redemption_type') == $type->value ? 'selected' : '' }}>
                                        {{ $type->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('redemption_type')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="3" class="form-textarea"
                                placeholder="Catatan tambahan untuk admin...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                            <div class="flex gap-3">
                                <p class="text-sm text-amber-800">
                                    Penukaran akan diproses oleh admin. Saldo akan dipotong setelah penukaran disetujui.
                                </p>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary w-full py-3">
                            Ajukan Penukaran
                        </button>
                    </form>
                @else
                    <div class="text-center py-8">
                        <h3 class="font-semibold text-gray-900 mb-2">Saldo Tidak Mencukupi</h3>
                        <p class="text-gray-600">Minimal saldo untuk penukaran adalah Rp 10.000.</p>
                        <a href="{{ route('warga.waste-bank.index') }}" class="btn-primary mt-4">
                            Lihat Bank Sampah
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Redemption History -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Riwayat Penukaran</h3>
            </div>
            <div class="card-body p-0">
                @forelse($redemptions as $redemption)
                    <div class="px-6 py-4 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $redemption->formatted_amount }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $redemption->redemption_type->label() }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $redemption->created_at->format('d M Y H:i') }}
                                </div>
                            </div>
                            <span class="{{ $redemption->status->badgeClass() }}">
                                {{ $redemption->status->label() }}
                            </span>
                        </div>
                        @if($redemption->notes)
                            <div class="mt-2 text-sm text-gray-600 bg-gray-50 rounded-lg p-2">
                                {{ $redemption->notes }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <p>Belum ada riwayat penukaran</p>
                    </div>
                @endforelse
            </div>
            @if($redemptions->hasPages())
                <div class="card-footer">
                    {{ $redemptions->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('warga.waste-bank.index') }}" class="btn-outline">
            Kembali ke Bank Sampah
        </a>
    </div>
</x-layouts.warga>