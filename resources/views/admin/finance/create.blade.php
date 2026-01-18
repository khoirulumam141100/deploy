<x-layouts.admin :title="'Tambah Transaksi'" :header="'Tambah Transaksi Baru'">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-600">Catat transaksi keuangan baru</p>
        <a href="{{ route('admin.finance.index') }}" class="btn-secondary">
            ← Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card max-w-2xl">
        <div class="card-body">
            <form action="{{ route('admin.transactions.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Category -->
                <div>
                    <label for="category_id" class="form-label">Kategori <span class="text-red-500">*</span></label>
                    <select 
                        id="category_id" 
                        name="category_id" 
                        class="form-select @error('category_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $selectedCategory) == $category->id ? 'selected' : '' }}>
                                {{ $category->icon }} {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label class="form-label">Tipe Transaksi <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        @foreach($types as $type)
                            <label class="relative cursor-pointer">
                                <input
                                    type="radio"
                                    name="type"
                                    value="{{ $type->value }}"
                                    class="peer sr-only"
                                    {{ old('type') === $type->value ? 'checked' : '' }}
                                    required
                                >
                                <div class="flex items-center justify-center gap-2 p-4 rounded-lg border-2 border-gray-200 peer-checked:border-primary-500 peer-checked:bg-primary-50 transition-all">
                                    <span class="text-2xl">{{ $type->value === 'income' ? '📈' : '📉' }}</span>
                                    <span class="font-medium {{ $type->value === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $type->label() }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('type')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- RT -->
                <div>
                    <label for="rt_id" class="form-label">RT <span class="text-red-500">*</span></label>
                    <select
                        id="rt_id"
                        name="rt_id"
                        class="form-select @error('rt_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">Pilih RT...</option>
                        @foreach($rts as $rt)
                            <option value="{{ $rt->id }}" {{ old('rt_id', $selectedRtId) == $rt->id ? 'selected' : '' }}>
                                {{ $rt->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('rt_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount_display" class="form-label">Jumlah (Rp) <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        id="amount_display" 
                        value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}"
                        class="form-input @error('amount') border-red-500 @enderror" 
                        placeholder="0"
                        required
                        inputmode="numeric"
                    >
                    <input type="hidden" id="amount" name="amount" value="{{ old('amount') }}">
                    @error('amount')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-label">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="form-textarea @error('description') border-red-500 @enderror" 
                        placeholder="Contoh: Iuran mingguan tanggal 25 Desember 2024"
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Transaction Date -->
                <div>
                    <label for="transaction_date" class="form-label">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input 
                        type="date" 
                        id="transaction_date" 
                        name="transaction_date" 
                        value="{{ old('transaction_date', date('Y-m-d')) }}"
                        class="form-input @error('transaction_date') border-red-500 @enderror" 
                        required
                    >
                    @error('transaction_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        💾 Simpan Transaksi
                    </button>
                    <a href="{{ route('admin.finance.index') }}" class="btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const amountDisplay = document.getElementById('amount_display');
            const amountHidden = document.getElementById('amount');

            // Format number with Indonesian thousand separator (dots)
            function formatRupiah(number) {
                if (!number) return '';
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Remove formatting to get raw number
            function unformatRupiah(str) {
                return str.replace(/\./g, '');
            }

            amountDisplay.addEventListener('input', function(e) {
                // Remove non-digits (including commas)
                let value = this.value.replace(/[^\d]/g, '');
                
                // Update hidden field with raw number
                amountHidden.value = value;
                
                // Format display with dots
                this.value = formatRupiah(value);
            });

            // Ensure cursor stays at end when typing
            amountDisplay.addEventListener('keyup', function(e) {
                if (e.key !== 'Backspace' && e.key !== 'Delete') {
                    this.setSelectionRange(this.value.length, this.value.length);
                }
            });
        </script>
    @endpush
</x-layouts.admin>
