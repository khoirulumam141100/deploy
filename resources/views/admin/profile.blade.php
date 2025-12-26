<x-layouts.admin :title="'Profil Saya'" :header="'Profil Saya'">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-body text-center">
                    <div
                        class="w-24 h-24 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-3xl mx-auto mb-4">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>

                    <div class="mt-4">
                        <span class="badge-info">{{ $user->role->label() }}</span>
                    </div>

                    <div class="mt-6 text-sm text-gray-500">
                        <p>Bergabung sejak</p>
                        <p class="font-medium text-gray-900">
                            {{ $user->joined_at?->format('d F Y') ?? $user->created_at->format('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Form -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Informasi Profil</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    class="form-input @error('name') border-red-500 @enderror" required>
                                @error('name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="form-input @error('email') border-red-500 @enderror" required>
                                @error('email')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="form-input @error('phone') border-red-500 @enderror" required>
                                @error('phone')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select id="gender" name="gender"
                                    class="form-select @error('gender') border-red-500 @enderror" required>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender['value'] }}" {{ old('gender', $user->gender?->value) === $gender['value'] ? 'selected' : '' }}>
                                            {{ $gender['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gender')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="birth_date" name="birth_date"
                                    value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                    class="form-input @error('birth_date') border-red-500 @enderror" required>
                                @error('birth_date')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="form-label">Alamat</label>
                            <textarea id="address" name="address" rows="3"
                                class="form-textarea @error('address') border-red-500 @enderror"
                                required>{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary">
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Form -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Ubah Password</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" id="current_password" name="current_password"
                                class="form-input @error('current_password') border-red-500 @enderror" required>
                            @error('current_password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" id="password" name="password"
                                    class="form-input @error('password') border-red-500 @enderror"
                                    placeholder="Minimal 8 karakter" required>
                                @error('password')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-input" required>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary">
                                🔐 Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>