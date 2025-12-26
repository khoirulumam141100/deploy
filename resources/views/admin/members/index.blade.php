<x-layouts.admin :title="'Kelola Anggota'" :header="'Manajemen Anggota'">
    <!-- Page Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-gray-600">Kelola data anggota PADRP ASSYUKRO</p>
        </div>
        <div class="flex gap-3">
            @if(\App\Models\User::members()->pending()->count() > 0)
                <a href="{{ route('admin.members.pending') }}" class="btn-secondary">
                    <span>⏳</span>
                    <span>Pending ({{ \App\Models\User::members()->pending()->count() }})</span>
                </a>
            @endif
            <a href="{{ route('admin.members.create') }}" class="btn-primary">
                <span>+</span>
                <span>Tambah Anggota</span>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('admin.members.index') }}"
                class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" class="form-input"
                        placeholder="Cari nama, email, atau telepon..." autocomplete="off">
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
                    <a href="{{ route('admin.members.index') }}" class="btn-secondary">
                        ✕ Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
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

            const searchInput = document.getElementById('searchInput');
            const filterForm = document.getElementById('filterForm');
            const statusSelect = document.getElementById('statusSelect');

            const submitForm = debounce(() => {
                filterForm.submit();
            }, 500);

            searchInput?.addEventListener('input', submitForm);
            statusSelect?.addEventListener('change', () => filterForm.submit());

            // Auto-focus search input if there's a search query
            if (searchInput?.value) {
                searchInput.focus();
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }
        </script>
    @endpush

    <!-- Members Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Anggota</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Gender</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Bergabung</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($members as $member)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-semibold">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $member->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $member->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $member->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $member->gender?->label() ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="{{ $member->status->badgeClass() }}">
                                    {{ $member->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $member->joined_at?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.members.show', $member) }}"
                                        class="text-gray-500 hover:text-primary-600" title="Lihat">
                                        👁️
                                    </a>
                                    <a href="{{ route('admin.members.edit', $member) }}"
                                        class="text-gray-500 hover:text-yellow-600" title="Edit">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.members.destroy', $member) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-600" title="Hapus">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="text-4xl mb-2">👥</div>
                                <p>Belum ada anggota terdaftar</p>
                                <a href="{{ route('admin.members.create') }}" class="btn-primary mt-4 inline-flex">
                                    + Tambah Anggota Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>