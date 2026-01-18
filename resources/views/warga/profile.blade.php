<x-layouts.warga :title="'Profil Saya'" :header="'Profil Saya'">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Info -->
            <div class="card">
                <div class="card-header flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Informasi Pribadi</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('warga.profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="name" class="form-label">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name"
                                    class="form-input @error('name') border-red-500 @enderror"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email"
                                    class="form-input @error('email') border-red-500 @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="form-label">No. Telepon <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="phone" name="phone"
                                    class="form-input @error('phone') border-red-500 @enderror"
                                    value="{{ old('phone', $user->phone) }}" required>
                                @error('phone')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="birth_date" name="birth_date" class="form-input"
                                    value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}">
                            </div>
                            <div>
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select id="gender" name="gender" class="form-select">
                                    <option value="">Pilih...</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender->value }}" {{ old('gender', $user->gender?->value) == $gender->value ? 'selected' : '' }}>
                                            {{ $gender->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="occupation" class="form-label">Pekerjaan</label>
                                <input type="text" id="occupation" name="occupation" class="form-input"
                                    value="{{ old('occupation', $user->occupation) }}">
                            </div>
                            <div>
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" id="nik" name="nik" class="form-input" maxlength="16"
                                    value="{{ old('nik', $user->nik) }}">
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="form-label">Alamat Lengkap <span
                                        class="text-red-500">*</span></label>
                                <textarea id="address" name="address" rows="3"
                                    class="form-textarea @error('address') border-red-500 @enderror"
                                    required>{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="btn-primary">
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Ubah Password</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('warga.profile.password') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="form-label">Password Saat Ini <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password"
                                    class="form-input pr-10 @error('current_password') border-red-500 @enderror"
                                    required>
                                <button type="button"
                                    onclick="togglePassword('current_password', 'eyeIcon1', 'eyeOffIcon1')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                    <svg id="eyeIcon1" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeOffIcon1" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="form-label">Password Baru <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="password" id="password" name="password"
                                        class="form-input pr-10 @error('password') border-red-500 @enderror" required
                                        minlength="8">
                                    <button type="button"
                                        onclick="togglePassword('password', 'eyeIcon2', 'eyeOffIcon2')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                        <svg id="eyeIcon2" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="eyeOffIcon2" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-input pr-10" required>
                                    <button type="button"
                                        onclick="togglePassword('password_confirmation', 'eyeIcon3', 'eyeOffIcon3')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                        <svg id="eyeIcon3" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="eyeOffIcon3" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="btn-outline">
                                🔒 Ubah Password
                            </button>
                        </div>
                    </form>
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
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Profile Summary -->
            <div class="card">
                <div class="card-body text-center">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-gray-500">{{ $user->rt?->full_name ?? 'RT/RW tidak ditentukan' }}</p>
                    <span class="{{ $user->status->badgeClass() }} mt-2 inline-block">
                        {{ $user->status->label() }}
                    </span>
                </div>
            </div>

            <!-- RT Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Info Keanggotaan</h3>
                </div>
                <div class="card-body space-y-3">
                    <div>
                        <div class="text-sm text-gray-500">RT/RW</div>
                        <div class="font-medium">{{ $user->rt?->full_name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Status Tinggal</div>
                        <div class="font-medium">
                            @if($user->residence_status)
                                {{ $user->residence_status->icon() }} {{ $user->residence_status->label() }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Terdaftar Sejak</div>
                        <div class="font-medium">{{ $user->created_at->format('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Bank Sampah -->
            <div class="card bg-gradient-to-br from-emerald-500 to-teal-600 text-white">
                <div class="card-body">
                    <div class="text-emerald-100 text-sm">Saldo Bank Sampah</div>
                    <div class="text-2xl font-bold mt-1">Rp {{ number_format($user->waste_balance, 0, ',', '.') }}</div>
                    <a href="{{ route('warga.waste-bank.index') }}"
                        class="mt-4 inline-flex items-center text-sm text-emerald-100 hover:text-white">
                        Kelola Bank Sampah →
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.warga>