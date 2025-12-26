<x-layouts.admin :title="'Tambah Kegiatan'" :header="'Tambah Kegiatan Baru'">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-600">Buat kegiatan baru untuk organisasi</p>
        <a href="{{ route('admin.events.index') }}" class="btn-secondary">
            ← Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card max-w-2xl">
        <div class="card-body">
            <form action="{{ route('admin.events.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="form-label">Judul Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        class="form-input @error('title') border-red-500 @enderror"
                        placeholder="Contoh: Pengajian Rutin Mingguan" required>
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-label">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="4"
                        class="form-textarea @error('description') border-red-500 @enderror"
                        placeholder="Jelaskan detail kegiatan..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Date -->
                <div>
                    <label for="event_date" class="form-label">Tanggal Kegiatan <span
                            class="text-red-500">*</span></label>
                    <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}"
                        class="form-input @error('event_date') border-red-500 @enderror" required>
                    @error('event_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="form-label">Waktu Mulai <span
                                class="text-red-500">*</span></label>
                        <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}"
                            class="form-input @error('start_time') border-red-500 @enderror" required>
                        @error('start_time')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_time" class="form-label">Waktu Selesai <span
                                class="text-red-500">*</span></label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}"
                            class="form-input @error('end_time') border-red-500 @enderror" required>
                        @error('end_time')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="form-label">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}"
                        class="form-input @error('location') border-red-500 @enderror"
                        placeholder="Contoh: Masjid Al-Ikhlas" required>
                    @error('location')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        💾 Simpan Kegiatan
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>