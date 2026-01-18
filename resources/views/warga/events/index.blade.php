<x-layouts.warga :title="'Kegiatan'" :header="'Kegiatan RT/RW'">
    <!-- Filter -->
    <div class="flex flex-wrap items-center gap-3 mb-6">
        <a href="{{ route('warga.events.index') }}"
            class="px-4 py-2 rounded-lg border text-sm font-medium transition-colors {{ !request('filter') ? 'bg-green-600 text-white border-green-600 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
            Semua
        </a>
        <a href="{{ route('warga.events.index', ['filter' => 'upcoming']) }}"
            class="px-4 py-2 rounded-lg border text-sm font-medium transition-colors {{ request('filter') == 'upcoming' ? 'bg-green-600 text-white border-green-600 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
            Mendatang
        </a>
        <a href="{{ route('warga.events.index', ['filter' => 'past']) }}"
            class="px-4 py-2 rounded-lg border text-sm font-medium transition-colors {{ request('filter') == 'past' ? 'bg-green-600 text-white border-green-600 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
            Selesai
        </a>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <a href="{{ route('warga.events.show', $event) }}" class="card hover:shadow-lg transition-shadow">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                        class="w-full h-40 object-cover rounded-t-xl">
                @else
                    <div
                        class="w-full h-40 bg-gradient-to-br from-green-100 to-teal-100 rounded-t-xl flex items-center justify-center text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="{{ $event->status->badgeClass() }} text-xs">
                            {{ $event->status->label() }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $event->event_date->format('d M Y') }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $event->title }}</h3>
                    <p class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($event->description, 100) }}</p>
                    <div class="mt-3 flex items-center gap-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $event->formatted_time }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ Str::limit($event->location, 20) }}
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full">
                <div class="card p-12 text-center">
                    <div
                        class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Kegiatan</h3>
                    <p class="text-gray-500">Tidak ada kegiatan yang sesuai dengan filter Anda.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
        <div class="mt-6">
            {{ $events->links() }}
        </div>
    @endif
</x-layouts.warga>