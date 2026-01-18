<x-layouts.warga :title="$event->title" :header="'Detail Kegiatan'">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('warga.events.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            ← Kembali ke Daftar Kegiatan
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="card overflow-hidden">
            <!-- Image -->
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                    class="w-full h-64 object-cover">
            @else
                <div class="w-full h-64 bg-gradient-to-br from-green-100 to-teal-100 flex items-center justify-center">
                    <span class="text-7xl">📅</span>
                </div>
            @endif

            <div class="p-6">
                <!-- Status & Category -->
                <div class="flex items-center gap-3 mb-4">
                    <span class="{{ $event->status->badgeClass() }}">
                        {{ $event->status->label() }}
                    </span>
                    @if($event->category)
                        <span class="badge-secondary">
                            {{ $event->category }}
                        </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>

                <!-- Event Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-xl">
                            📆
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Tanggal</div>
                            <div class="font-medium">{{ $event->formatted_date }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center text-xl">
                            ⏰
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Waktu</div>
                            <div class="font-medium">{{ $event->formatted_time }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center text-xl">
                            📍
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Lokasi</div>
                            <div class="font-medium">{{ $event->location }}</div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Deskripsi</h3>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <!-- Additional Info -->
                @if($event->organizer || $event->contact_person)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-3">Informasi Tambahan</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @if($event->organizer)
                                <div>
                                    <div class="text-sm text-gray-500">Penyelenggara</div>
                                    <div class="font-medium">{{ $event->organizer }}</div>
                                </div>
                            @endif
                            @if($event->contact_person)
                                <div>
                                    <div class="text-sm text-gray-500">Narahubung</div>
                                    <div class="font-medium">{{ $event->contact_person }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.warga>