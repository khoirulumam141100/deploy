<x-layouts.member :title="'Profil Saya'" :header="'Profil Saya'">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-body text-center">
                    <div
                        class="w-24 h-24 rounded-full bg-secondary-100 flex items-center justify-center text-secondary-700 font-bold text-3xl mx-auto mb-4">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>

                    <div class="mt-4">
                        <span class="{{ $user->status->badgeClass() }}">{{ $user->status->label() }}</span>
                    </div>

                    <div class="mt-6 text-sm text-gray-500">
                        <p>Bergabung sejak</p>
                        <p class="font-medium text-gray-900">{{ $user->joined_at?->format('d F Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Member Info -->
            <div class="card mt-6">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Informasi Keanggotaan</h3>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Status</span>
                        <span class="{{ $user->status->badgeClass() }}">{{ $user->status->label() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Bergabung</span>
                        <span class="text-gray-900">{{ $user->joined_at?->format('d M Y') ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Usia</span>
                        <span class="text-gray-900">{{ $user->age ?? '-' }} tahun</span>
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
                    <form action="{{ route('member.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Name (Read only display) -->
                        <div>
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-input @error('name') border-red-500 @enderror" required>
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email (Read only) -->
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" value="{{ $user->email }}" class="form-input bg-gray-50" disabled>
                            <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
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
                            <button type="submit" class="btn-success">
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
                    <form action="{{ route('member.profile.password') }}" method="POST" class="space-y-6">
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
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-input" required>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-success">
                                🔐 Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.member>