<x-layouts.member :title="$event->title" :header="'Detail Kegiatan'">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('member.events.index') }}" class="btn-secondary">
            ← Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-4">
                        <span class="{{ $event->status->badgeClass() }}">
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
                    <h3 class="font-semibold text-gray-900">📋 Detail Kegiatan</h3>
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

            <!-- Status Card -->
            @if($event->status->value === 'upcoming')
                <div class="card bg-yellow-50 border-yellow-200">
                    <div class="card-body text-center">
                        <div class="text-4xl mb-2">📢</div>
                        <p class="text-sm text-yellow-800">Kegiatan akan dilaksanakan</p>
                        <p class="font-bold text-yellow-900 mt-1">{{ $event->event_date->diffForHumans() }}</p>
                    </div>
                </div>
            @elseif($event->status->value === 'ongoing')
                <div class="card bg-yellow-50 border-yellow-200">
                    <div class="card-body text-center">
                        <div class="text-4xl mb-2">🎉</div>
                        <p class="text-sm text-yellow-800">Kegiatan sedang berlangsung!</p>
                    </div>
                </div>
            @else
                <div class="card bg-green-50 border-green-200">
                    <div class="card-body text-center">
                        <div class="text-4xl mb-2">✅</div>
                        <p class="text-sm text-green-800">Kegiatan telah selesai dilaksanakan</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.member>