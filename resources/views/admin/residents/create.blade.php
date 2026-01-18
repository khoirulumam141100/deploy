<x-layouts.admin :title="'Tambah Warga'" :header="'Tambah Warga Baru'">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('admin.residents.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            ← Kembali ke Daftar Warga
        </a>
    </div>

    <div class="max-w-3xl">
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-gray-900">Form Tambah Warga</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.residents.store') }}" class="space-y-6">
                    @csrf

                    <!-- Basic Info -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="font-medium text-gray-700 mb-4">Informasi Dasar</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" class="form-input @error('name') border-red-500 @enderror"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" id="nik" name="nik" class="form-input @error('nik') border-red-500 @enderror"
                                    value="{{ old('nik') }}" maxlength="16" placeholder="16 digit NIK">
                                @error('nik')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" class="form-input @error('email') border-red-500 @enderror"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="form-label">No. Telepon <span class="text-red-500">*</span></label>
                                <input type="text" id="phone" name="phone" class="form-input @error('phone') border-red-500 @enderror"
                                    value="{{ old('phone') }}" required>
                                @error('phone')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" class="form-input pr-10 @error('password') border-red-500 @enderror"
                                        required minlength="8">
                                    <button type="button" onclick="togglePassword('password', 'eyeIconCreate', 'eyeOffIconCreate')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                        <svg id="eyeIconCreate" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="eyeOffIconCreate" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="font-medium text-gray-700 mb-4">Data Pribadi</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="birth_date" class="form-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" id="birth_date" name="birth_date" class="form-input @error('birth_date') border-red-500 @enderror"
                                    value="{{ old('birth_date') }}" required>
                                @error('birth_date')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="gender" class="form-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select id="gender" name="gender" class="form-select @error('gender') border-red-500 @enderror" required>
                                    <option value="">Pilih...</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender->value }}" {{ old('gender') == $gender->value ? 'selected' : '' }}>
                                            {{ $gender->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gender')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="occupation" class="form-label">Pekerjaan</label>
                                <input type="text" id="occupation" name="occupation" class="form-input"
                                    value="{{ old('occupation') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="font-medium text-gray-700 mb-4">Alamat</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="rt_id" class="form-label">RT <span class="text-red-500">*</span></label>
                                <select id="rt_id" name="rt_id" class="form-select @error('rt_id') border-red-500 @enderror" required>
                                    <option value="">Pilih RT...</option>
                                    @foreach($rts as $rt)
                                        <option value="{{ $rt->id }}" {{ old('rt_id') == $rt->id ? 'selected' : '' }}>
                                            {{ $rt->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rt_id')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="residence_status" class="form-label">Status Tinggal <span class="text-red-500">*</span></label>
                                <select id="residence_status" name="residence_status" class="form-select @error('residence_status') border-red-500 @enderror" required>
                                    <option value="">Pilih...</option>
                                    @foreach($residenceStatuses as $status)
                                        <option value="{{ $status->value }}" {{ old('residence_status') == $status->value ? 'selected' : '' }}>
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('residence_status')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="status" class="form-label">Status Akun <span class="text-red-500">*</span></label>
                                <select id="status" name="status" class="form-select @error('status') border-red-500 @enderror" required>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->value }}" {{ old('status', 'active') == $status->value ? 'selected' : '' }}>
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-3">
                                <label for="address" class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea id="address" name="address" rows="3" class="form-textarea @error('address') border-red-500 @enderror"
                                    required>{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary flex-1">
                            💾 Simpan Warga
                        </button>
                        <a href="{{ route('admin.residents.index') }}" class="btn-outline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, eyeIconId, eyeOffIconId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeIconId);
            const eyeOffIcon = document.getElementById(eyeOffIconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</x-layouts.admin>
