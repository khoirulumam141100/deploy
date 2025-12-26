<x-layouts.admin :title="'Edit Anggota'" :header="'Edit Data Anggota'">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-600">Edit data anggota: <strong>{{ $member->name }}</strong></p>
        <a href="{{ route('admin.members.index') }}" class="btn-secondary">
            ← Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card max-w-2xl">
        <div class="card-body">
            <form action="{{ route('admin.members.update', $member) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $member->name) }}"
                        class="form-input @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}"
                        class="form-input @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="form-label">No. Telepon <span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $member->phone) }}"
                        class="form-input @error('phone') border-red-500 @enderror" required>
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea id="address" name="address" rows="3"
                        class="form-textarea @error('address') border-red-500 @enderror"
                        required>{{ old('address', $member->address) }}</textarea>
                    @error('address')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Date & Gender -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="birth_date" class="form-label">Tanggal Lahir <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="birth_date" name="birth_date"
                            value="{{ old('birth_date', $member->birth_date?->format('Y-m-d')) }}"
                            class="form-input @error('birth_date') border-red-500 @enderror" required>
                        @error('birth_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="gender" class="form-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select id="gender" name="gender" class="form-select @error('gender') border-red-500 @enderror"
                            required>
                            <option value="">Pilih...</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender['value'] }}" {{ old('gender', $member->gender?->value) === $gender['value'] ? 'selected' : '' }}>
                                    {{ $gender['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('gender')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                    <select id="status" name="status" class="form-select @error('status') border-red-500 @enderror"
                        required>
                        @foreach($statuses as $status)
                            <option value="{{ $status['value'] }}" {{ old('status', $member->status->value) === $status['value'] ? 'selected' : '' }}>
                                {{ $status['label'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Member Info -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-2">Informasi Tambahan</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Terdaftar:</span>
                            <span class="text-gray-900 ml-2">{{ $member->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Bergabung:</span>
                            <span class="text-gray-900 ml-2">{{ $member->joined_at?->format('d M Y') ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        💾 Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.members.index') }}" class="btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>