<x-layouts.admin :title="$event->title" :header="'Detail Kegiatan'">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.events.index') }}" class="btn-secondary">
            ← Kembali
        </a>
        <div class="flex gap-3">
            <a href="{{ route('admin.events.edit', $event) }}" class="btn-primary">
                ✏️ Edit
            </a>
            <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    🗑️ Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-4">
                        <span class="{{ $event->status->badgeClass() }} text-sm">
                            {{ $event->status->label() }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>

                    <!-- Description -->
                    <div class="prose prose-sm max-w-none text-gray-600">
                        <p>{{ $event->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Event Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Informasi Kegiatan</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="text-xl">📆</span>
                        <div>
                            <div class="text-sm text-gray-500">Tanggal</div>
                            <div class="font-medium text-gray-900">{{ $event->formatted_date }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-xl">⏰</span>
                        <div>
                            <div class="text-sm text-gray-500">Waktu</div>
                            <div class="font-medium text-gray-900">{{ $event->formatted_time }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-xl">📍</span>
                        <div>
                            <div class="text-sm text-gray-500">Lokasi</div>
                            <div class="font-medium text-gray-900">{{ $event->location }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Created Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-gray-900">Dibuat Oleh</h3>
                </div>
                <div class="card-body">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-semibold">
                            {{ strtoupper(substr($event->creator?->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $event->creator?->name ?? 'Admin' }}</div>
                            <div class="text-sm text-gray-500">{{ $event->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            @if($event->status->value === 'upcoming')
                <div class="card bg-yellow-50 border-yellow-200">
                    <div class="card-body text-center">
                        <div class="text-4xl mb-2">📢</div>
                        <p class="text-sm text-yellow-800">Kegiatan akan dilaksanakan pada:</p>
                        <p class="font-bold text-yellow-900 mt-1">{{ $event->event_date->diffForHumans() }}</p>
                    </div>
                </div>
            @elseif($event->status->value === 'completed')
                <div class="card bg-green-50 border-green-200">
                    <div class="card-body text-center">
                        <div class="text-4xl mb-2">✅</div>
                        <p class="text-sm text-green-800">Kegiatan telah selesai dilaksanakan</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>