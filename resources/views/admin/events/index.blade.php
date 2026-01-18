<x-layouts.admin :title="'Kegiatan'" :header="'Manajemen Kegiatan'">
    <!-- Page Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-gray-600">Kelola kegiatan dan acara RT/RW Kauman</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn-primary">
            <span>+</span>
            <span>Tambah Kegiatan</span>
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('admin.events.index') }}"
                class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" class="form-input"
                        placeholder="Cari judul atau lokasi..." autocomplete="off">
                </div>
                <div class="w-full sm:w-48">
                    <select name="status" id="statusSelect" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status['value'] }}" {{ request('status') === $status['value'] ? 'selected' : '' }}>
                                {{ $status['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.events.index') }}" class="btn-secondary">
                        ✕ Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Debounce function to limit API calls
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Auto-submit form on search input (with debounce)
            const searchInput = document.getElementById('searchInput');
            const filterForm = document.getElementById('filterForm');
            const statusSelect = document.getElementById('statusSelect');

            const submitForm = debounce(() => {
                filterForm.submit();
            }, 500); // Wait 500ms after typing stops

            searchInput.addEventListener('input', submitForm);

            // Immediate submit on status change
            statusSelect.addEventListener('change', () => {
                filterForm.submit();
            });

            // Auto-focus search input if there's a search query
            if (searchInput.value) {
                searchInput.focus();
                // Move cursor to end of text
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }
        </script>
    @endpush

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="card group hover:shadow-lg transition-shadow">
                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="{{ $event->status->badgeClass() }}">
                            {{ $event->status->label() }}
                        </span>
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.events.edit', $event) }}" class="text-gray-500 hover:text-yellow-600"
                                title="Edit">
                                ✏️
                            </a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-red-600" title="Hapus">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Title -->
                    <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $event->title }}</h3>

                    <!-- Description -->
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $event->description }}</p>

                    <!-- Details -->
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <span>📆</span>
                            <span>{{ $event->formatted_date }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <span>⏰</span>
                            <span>{{ $event->formatted_time }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <span>📍</span>
                            <span>{{ $event->location }}</span>
                        </div>
                    </div>

                    <!-- View Button -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.events.show', $event) }}" class="btn-outline w-full text-center">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="card">
                    <div class="card-body py-12 text-center">
                        <div class="text-6xl mb-4">📅</div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Kegiatan</h3>
                        <p class="text-gray-500 mb-6">Mulai tambahkan kegiatan untuk organisasi</p>
                        <a href="{{ route('admin.events.create') }}" class="btn-primary">
                            + Tambah Kegiatan Pertama
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @if($events->hasPages())
        <div class="mt-6">
            {{ $events->links() }}
        </div>
    @endif
</x-layouts.admin>