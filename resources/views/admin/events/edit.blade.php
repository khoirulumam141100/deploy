<x-layouts.admin :title="'Edit Kegiatan'" :header="'Edit Kegiatan'">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-600">Edit data kegiatan: <strong>{{ $event->title }}</strong></p>
        <a href="{{ route('admin.events.index') }}" class="btn-secondary">
            ← Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card max-w-2xl">
        <div class="card-body">
            <form action="{{ route('admin.events.update', $event) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="form-label">Judul Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}"
                        class="form-input @error('title') border-red-500 @enderror" required>
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-label">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="4"
                        class="form-textarea @error('description') border-red-500 @enderror"
                        required>{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Date -->
                <div>
                    <label for="event_date" class="form-label">Tanggal Kegiatan <span
                            class="text-red-500">*</span></label>
                    <input type="date" id="event_date" name="event_date"
                        value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}"
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
                        <input type="time" id="start_time" name="start_time"
                            value="{{ old('start_time', $event->start_time?->format('H:i')) }}"
                            class="form-input @error('start_time') border-red-500 @enderror" required>
                        @error('start_time')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_time" class="form-label">Waktu Selesai <span
                                class="text-red-500">*</span></label>
                        <input type="time" id="end_time" name="end_time"
                            value="{{ old('end_time', $event->end_time?->format('H:i')) }}"
                            class="form-input @error('end_time') border-red-500 @enderror" required>
                        @error('end_time')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="form-label">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}"
                        class="form-input @error('location') border-red-500 @enderror" required>
                    @error('location')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                    <select id="status" name="status" class="form-select @error('status') border-red-500 @enderror"
                        required>
                        @foreach($statuses as $status)
                            <option value="{{ $status['value'] }}" {{ old('status', $event->status->value) === $status['value'] ? 'selected' : '' }}>
                                {{ $status['label'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-2">Informasi</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Dibuat oleh:</span>
                            <span class="text-gray-900 ml-2">{{ $event->creator?->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Dibuat pada:</span>
                            <span class="text-gray-900 ml-2">{{ $event->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="btn-primary">
                        💾 Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>