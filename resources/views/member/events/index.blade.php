<x-layouts.member :title="'Kegiatan'" :header="'Kegiatan Organisasi'">
    <!-- Page Header -->
    <div class="mb-6">
        <p class="text-gray-600">Lihat semua kegiatan PADRP ASSYUKRO</p>
    </div>

    <!-- Filter Tabs -->
    <div class="flex gap-2 mb-6 flex-wrap">
        <a href="{{ route('member.events.index', ['filter' => 'all']) }}"
            class="{{ $filter === 'all' ? 'btn-primary' : 'btn-secondary' }}">
            Semua
        </a>
        <a href="{{ route('member.events.index', ['filter' => 'ongoing']) }}"
            class="{{ $filter === 'ongoing' ? 'btn-primary' : 'btn-secondary' }}">
            Sedang Berlangsung
        </a>
        <a href="{{ route('member.events.index', ['filter' => 'upcoming']) }}"
            class="{{ $filter === 'upcoming' ? 'btn-primary' : 'btn-secondary' }}">
            Akan Datang
        </a>
        <a href="{{ route('member.events.index', ['filter' => 'completed']) }}"
            class="{{ $filter === 'completed' ? 'btn-primary' : 'btn-secondary' }}">
            Selesai
        </a>
    </div>

    <!-- Events List -->
    <div class="space-y-4">
        @forelse($events as $event)
            <a href="{{ route('member.events.show', $event) }}" class="card block hover:shadow-lg transition-shadow group">
                <div class="card-body">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <!-- Date Badge -->
                        <div
                            class="flex-shrink-0 w-20 h-20 rounded-xl bg-primary-100 flex flex-col items-center justify-center text-primary-700">
                            <span class="text-2xl font-bold">{{ $event->event_date->format('d') }}</span>
                            <span class="text-sm uppercase">{{ $event->event_date->format('M') }}</span>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="{{ $event->status->badgeClass() }} text-xs">
                                    {{ $event->status->label() }}
                                </span>
                            </div>
                            <h3 class="font-semibold text-lg text-gray-900 group-hover:text-primary-600 transition-colors">
                                {{ $event->title }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $event->description }}</p>

                            <div class="flex flex-wrap gap-4 mt-3 text-sm text-gray-500">
                                <div class="flex items-center gap-1">
                                    <span>⏰</span>
                                    <span>{{ $event->formatted_time }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span>📍</span>
                                    <span>{{ $event->location }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Arrow -->
                        <div class="text-gray-400 group-hover:text-primary-600 transition-colors">
                            →
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="card">
                <div class="card-body py-12 text-center">
                    <div class="text-6xl mb-4">📅</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Kegiatan</h3>
                    <p class="text-gray-500">
                        @if($filter === 'ongoing')
                            Tidak ada kegiatan yang sedang berlangsung
                        @elseif($filter === 'upcoming')
                            Tidak ada kegiatan yang akan datang
                        @elseif($filter === 'completed')
                            Belum ada kegiatan yang selesai
                        @else
                            Belum ada kegiatan yang dijadwalkan
                        @endif
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    @if($events->hasPages())
        <div class="mt-6">
            {{ $events->links() }}
        </div>
    @endif
</x-layouts.member>