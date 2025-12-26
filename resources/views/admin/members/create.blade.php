<x-layouts.admin :title="'Tambah Anggota'" :header="'Tambah Anggota Baru'">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-600">Tambahkan anggota baru ke organisasi</p>
        <a href="{{ route('admin.members.index') }}" class="btn-secondary">
            ← Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card max-w-2xl">
        <div class="card-body">
            <form action="{{ route('admin.members.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="form-input @error('name') border-red-500 @enderror" placeholder="Masukkan nama lengkap"
                        required>
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="form-input @error('email') border-red-500 @enderror" placeholder="nama@email.com"
                        required>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="form-label">No. Telepon <span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                        class="form-input @error('phone') border-red-500 @enderror" placeholder="08xxxxxxxxxx" required>
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea id="address" name="address" rows="3"
                        class="form-textarea @error('address') border-red-500 @enderror"
                        placeholder="Masukkan alamat lengkap" required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Date & Gender -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="birth_date" class="form-label">Tanggal Lahir <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
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
                                <option value="{{ $gender['value'] }}" {{ old('gender') === $gender['value'] ? 'selected' : '' }}>
                                    {{ $gender['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('gender')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password"
                        class="form-input @error('password') border-red-500 @enderror" placeholder="Minimal 8 karakter"
                        required>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Password ini akan digunakan anggota untuk login</p>
                </div>

                <!-- Submit -->
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        💾 Simpan Anggota
                    </button>
                    <a href="{{ route('admin.members.index') }}" class="btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>