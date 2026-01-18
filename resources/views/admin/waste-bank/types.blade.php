<x-layouts.admin :title="'Jenis Sampah'" :header="'Kelola Jenis Sampah'">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add New Type Form -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Tambah Jenis Baru</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.waste-bank.types.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="form-label">Nama <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" class="form-input @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" placeholder="Contoh: Kertas HVS" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="price_per_kg" class="form-label">Harga per kg (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="price_per_kg" name="price_per_kg" class="form-input @error('price_per_kg') border-red-500 @enderror"
                            value="{{ old('price_per_kg') }}" min="100" step="100" required>
                        @error('price_per_kg')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="unit" class="form-label">Satuan</label>
                        <select id="unit" name="unit" class="form-select">
                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg (Kilogram)</option>
                            <option value="liter" {{ old('unit') == 'liter' ? 'selected' : '' }}>liter (Liter)</option>
                            <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs (Satuan)</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked
                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                        <label for="is_active" class="text-sm text-gray-700">Aktif</label>
                    </div>
                    <button type="submit" class="btn-primary w-full">
                        Tambah Jenis Sampah
                    </button>
                </form>
            </div>
        </div>

        <!-- Existing Types -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Daftar Jenis Sampah</h3>
                </div>
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>

                                    <th>Nama</th>
                                    <th class="text-right">Harga/kg</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Setoran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wasteTypes as $type)
                                    <tr>

                                        <td class="font-medium text-gray-900">{{ $type->name }}</td>
                                        <td class="text-right">{{ $type->formatted_price }}</td>
                                        <td class="text-center">
                                            @if($type->is_active)
                                                <span class="badge-success">Aktif</span>
                                            @else
                                                <span class="badge-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $type->waste_deposits_count }}</td>
                                        <td>
                                    <td>
                                        <div class="flex gap-2">
                                            <button type="button" onclick="editType({{ $type->id }}, '{{ $type->name }}', {{ $type->price_per_kg }}, '{{ $type->unit }}', {{ $type->is_active ? 'true' : 'false' }})"
                                                class="text-blue-600 hover:text-blue-800" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            @if($type->waste_deposits_count == 0)
                                                <form method="POST" action="{{ route('admin.waste-bank.types.destroy', $type) }}" 
                                                    onsubmit="return confirm('Yakin ingin menghapus jenis sampah ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center transition-all">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Edit Jenis Sampah</h3>
            </div>
            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="form-label">Nama <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_name" name="name" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Harga per kg (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" id="edit_price_per_kg" name="price_per_kg" class="form-input" min="100" step="100" required>
                </div>

                <div>
                    <label class="form-label">Satuan</label>
                    <select id="edit_unit" name="unit" class="form-select">
                        <option value="kg">kg (Kilogram)</option>
                        <option value="liter">liter (Liter)</option>
                        <option value="pcs">pcs (Satuan)</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1"
                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                    <label for="edit_is_active" class="text-sm text-gray-700">Aktif</label>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="btn-primary flex-1">Simpan</button>
                    <button type="button" onclick="closeEditModal()" class="btn-outline">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('admin.waste-bank.index') }}" class="btn-outline">
            Kembali ke Bank Sampah
        </a>
    </div>

    @push('scripts')
    <script>
        function editType(id, name, price, unit, isActive) {
            document.getElementById('editForm').action = '/admin/waste-bank/types/' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_price_per_kg').value = price;
            document.getElementById('edit_unit').value = unit;
            document.getElementById('edit_is_active').checked = isActive;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });
    </script>
    @endpush
</x-layouts.admin>
