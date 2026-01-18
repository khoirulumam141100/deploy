<x-layouts.admin :title="'Catat Setoran'" :header="'Catat Setoran Sampah Baru'">
    <div class="max-w-2xl">
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Form Setoran Baru</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.waste-bank.deposits.store') }}" class="space-y-6">
                    @csrf

                    <!-- Warga -->
                    <div>
                        <label for="user_id" class="form-label">Warga <span class="text-red-500">*</span></label>
                        <select id="user_id" name="user_id" class="form-select @error('user_id') border-red-500 @enderror" required>
                            <option value="">Pilih Warga...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->rt?->full_name ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Sampah -->
                    <div>
                        <label for="waste_type_id" class="form-label">Jenis Sampah <span class="text-red-500">*</span></label>
                        <select id="waste_type_id" name="waste_type_id" class="form-select @error('waste_type_id') border-red-500 @enderror" required>
                            <option value="">Pilih Jenis Sampah...</option>
                            @foreach($wasteTypes as $type)
                                <option value="{{ $type->id }}" 
                                    data-price="{{ $type->price_per_kg }}"
                                    {{ old('waste_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} - Rp {{ number_format($type->price_per_kg, 0, ',', '.') }}/kg
                                </option>
                            @endforeach
                        </select>
                        @error('waste_type_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Berat & Tanggal -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="weight" class="form-label">Berat (kg) <span class="text-red-500">*</span></label>
                            <input type="number" id="weight" name="weight" step="0.01" min="0.01"
                                class="form-input @error('weight') border-red-500 @enderror"
                                value="{{ old('weight') }}" required>
                            @error('weight')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="deposit_date" class="form-label">Tanggal Setoran <span class="text-red-500">*</span></label>
                            <input type="date" id="deposit_date" name="deposit_date"
                                class="form-input @error('deposit_date') border-red-500 @enderror"
                                value="{{ old('deposit_date', date('Y-m-d')) }}" required>
                            @error('deposit_date')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview -->
                    <div id="preview" class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 hidden">
                        <div class="text-sm text-emerald-700">Estimasi Pendapatan:</div>
                        <div class="text-2xl font-bold text-emerald-600" id="preview-amount">Rp 0</div>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea id="notes" name="notes" rows="3" class="form-textarea"
                            placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Submit -->
                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary flex-1">
                            Simpan Setoran
                        </button>
                        <a href="{{ route('admin.waste-bank.deposits') }}" class="btn-outline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wasteTypeSelect = document.getElementById('waste_type_id');
            const weightInput = document.getElementById('weight');
            const preview = document.getElementById('preview');
            const previewAmount = document.getElementById('preview-amount');

            function updatePreview() {
                const selectedOption = wasteTypeSelect.options[wasteTypeSelect.selectedIndex];
                const price = parseFloat(selectedOption.dataset.price) || 0;
                const weight = parseFloat(weightInput.value) || 0;
                const total = price * weight;

                if (weight > 0 && price > 0) {
                    preview.classList.remove('hidden');
                    previewAmount.textContent = 'Rp ' + total.toLocaleString('id-ID');
                } else {
                    preview.classList.add('hidden');
                }
            }

            wasteTypeSelect.addEventListener('change', updatePreview);
            weightInput.addEventListener('input', updatePreview);
        });
    </script>
    @endpush
</x-layouts.admin>
