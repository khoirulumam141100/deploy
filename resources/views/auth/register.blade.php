<x-layouts.guest title="Daftar Anggota">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-h-[90vh] overflow-y-auto">
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo PADRP Assyukro"
                class="w-20 h-20 mx-auto mb-4 rounded-xl shadow-lg">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Anggota Baru</h1>
            <p class="text-gray-500 mt-1">PADRP ASSYUKRO</p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="form-input @error('name') border-red-500 @enderror" placeholder="Masukkan nama lengkap"
                    required autofocus>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="form-input @error('email') border-red-500 @enderror" placeholder="nama@email.com" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="form-label">No. Telepon / WhatsApp</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                    class="form-input @error('phone') border-red-500 @enderror" placeholder="08xxxxxxxxxx" required>
                @error('phone')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="form-label">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="2"
                    class="form-textarea @error('address') border-red-500 @enderror"
                    placeholder="Masukkan alamat lengkap" required>{{ old('address') }}</textarea>
                @error('address')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Birth Date & Gender -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                        class="form-input @error('birth_date') border-red-500 @enderror" required>
                    @error('birth_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select id="gender" name="gender" class="form-select @error('gender') border-red-500 @enderror"
                        required>
                        <option value="">Pilih...</option>
                        @foreach(\App\Enums\Gender::options() as $option)
                            <option value="{{ $option['value'] }}" {{ old('gender') == $option['value'] ? 'selected' : '' }}>
                                {{ $option['label'] }}
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
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password"
                    class="form-input @error('password') border-red-500 @enderror" placeholder="Minimal 8 karakter"
                    required>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                    placeholder="Ulangi password" required>
            </div>

            <!-- Info -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-yellow-800">
                        Setelah mendaftar, akun Anda akan menunggu persetujuan dari admin. Anda akan dapat login setelah
                        akun disetujui.
                    </p>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-success w-full py-3 text-base">
                Daftar Sekarang
            </button>
        </form>

        <!-- Login Link -->
        <p class="text-center text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                Masuk di sini
            </a>
        </p>

        <!-- Back to Home -->
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</x-layouts.guest>