<x-layouts.guest title="Daftar Warga">
    <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl p-8 border border-white/50 max-h-[90vh] overflow-y-auto">
        <!-- Logo -->
        <div class="text-center mb-6">

            <h1 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">Daftar Warga Baru</h1>
            <p class="text-gray-500 mt-1 text-sm">Sistem Informasi Warga RT/RW Kauman</p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ selectedRw: '' }">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="form-input @error('name') border-red-500 @enderror" placeholder="Masukkan nama lengkap"
                    required autofocus>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIK -->
            <div>
                <label for="nik" class="form-label">NIK <span class="text-red-500">*</span></label>
                <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                    class="form-input @error('nik') border-red-500 @enderror" placeholder="16 digit NIK" maxlength="16" minlength="16" required>
                @error('nik')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email & Phone -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="form-input @error('email') border-red-500 @enderror" placeholder="nama@email.com" required>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="form-label">No. HP/WA <span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" maxlength="15"
                        class="form-input @error('phone') border-red-500 @enderror" placeholder="08xxxxxxxxxx" required>
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- RT/RW Selection -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="rw_select" class="form-label">RW <span class="text-red-500">*</span></label>
                    <select id="rw_select" x-model="selectedRw" class="form-select" required>
                        <option value="">Pilih RW...</option>
                        @foreach($rws as $rw)
                            <option value="{{ $rw->id }}">{{ $rw->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="rt_id" class="form-label">RT <span class="text-red-500">*</span></label>
                    <select id="rt_id" name="rt_id" class="form-select @error('rt_id') border-red-500 @enderror" required>
                        <option value="">Pilih RT...</option>
                        @foreach($rws as $rw)
                            @foreach($rw->rts as $rt)
                                <option value="{{ $rt->id }}" 
                                    x-show="selectedRw == '{{ $rw->id }}'"
                                    {{ old('rt_id') == $rt->id ? 'selected' : '' }}>
                                    {{ $rt->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('rt_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea id="address" name="address" rows="2"
                    class="form-textarea @error('address') border-red-500 @enderror"
                    placeholder="Jl. Nama Jalan No. XX" required>{{ old('address') }}</textarea>
                @error('address')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Birth Date & Gender -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="birth_date" class="form-label">Tgl Lahir <span class="text-red-500">*</span></label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                        class="form-input @error('birth_date') border-red-500 @enderror" required>
                    @error('birth_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="gender" class="form-label">Kelamin <span class="text-red-500">*</span></label>
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
            </div>

            <!-- Status & Occupation -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="residence_status" class="form-label">Status <span class="text-red-500">*</span></label>
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
                    <label for="occupation" class="form-label">Pekerjaan (Opsional)</label>
                    <input type="text" id="occupation" name="occupation" value="{{ old('occupation') }}"
                        class="form-input" placeholder="Wiraswasta, dll">
                </div>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="form-input pr-10 @error('password') border-red-500 @enderror" placeholder="Min. 8 karakter"
                            required>
                        <button type="button" onclick="togglePassword('password', 'eyeIcon1', 'eyeOffIcon1')"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                            <svg id="eyeIcon1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOffIcon1" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input pr-10"
                            placeholder="Ulangi password" required>
                        <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2', 'eyeOffIcon2')"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                            <svg id="eyeIcon2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOffIcon2" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <div class="flex gap-3">
                    <span class="text-xl">⚠️</span>
                    <p class="text-sm text-amber-800">
                        Setelah mendaftar, akun Anda akan diverifikasi oleh admin RT/RW. Anda akan dapat login setelah akun disetujui.
                    </p>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-primary w-full py-3 text-base flex items-center justify-center gap-2 group">
                <span>Daftar Sekarang</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </form>

        <!-- Login Link -->
        <p class="text-center text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold hover:underline">
                Masuk di sini
            </a>
        </p>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
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
</x-layouts.guest>