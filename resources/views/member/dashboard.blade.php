<x-layouts.member :title="'Dashboard'" :header="'Beranda'">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ $user->name }}! 👋</h2>
        <p class="text-gray-600 mt-1">Lihat informasi terbaru tentang organisasi PADRP ASSYUKRO.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Upcoming Events -->
        <div class="stat-card">
            <div class="stat-card-icon bg-primary-100 text-primary-600">
                📅
            </div>
            <div class="stat-card-value">{{ $upcomingEventsCount }}</div>
            <div class="stat-card-label">Kegiatan Mendatang</div>
        </div>

        <!-- Total Balance -->
        <div class="stat-card">
            <div class="stat-card-icon bg-secondary-100 text-secondary-600">
                💰
            </div>
            <div class="stat-card-value text-xl">{{ $formattedBalance }}</div>
            <div class="stat-card-label">Total Saldo Organisasi</div>
        </div>

        <!-- Active Members -->
        <div class="stat-card">
            <div class="stat-card-icon bg-purple-100 text-purple-600">
                👥
            </div>
            <div class="stat-card-value">{{ $totalActiveMembers }}</div>
            <div class="stat-card-label">Anggota Aktif</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Events -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Kegiatan Mendatang</h3>
                <a href="{{ route('member.events.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                    Lihat Semua →
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($upcomingEvents as $event)
                    <a href="{{ route('member.events.show', $event) }}"
                        class="block px-6 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ $event->title }}</div>
                                <div class="text-sm text-gray-500 mt-1">
                                    📆 {{ $event->formatted_date }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    ⏰ {{ $event->formatted_time }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    📍 {{ $event->location }}
                                </div>
                            </div>
                            <span class="{{ $event->status->badgeClass() }}">
                                {{ $event->status->label() }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <div class="text-4xl mb-2">📅</div>
                        <p>Belum ada kegiatan yang dijadwalkan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Finance Summary -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Ringkasan Keuangan</h3>
                <a href="{{ route('member.finance.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                    Lihat Detail →
                </a>
            </div>
            <div class="card-body p-0">
                @foreach($categories as $category)
                    <a href="{{ route('member.finance.category', $category) }}"
                        class="block px-6 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg
                                        @if($category->color === 'teal') bg-teal-100
                                        @elseif($category->color === 'green') bg-green-100
                                        @elseif($category->color === 'purple') bg-purple-100
                                        @elseif($category->color === 'yellow') bg-yellow-100
                                        @else bg-gray-100
                                        @endif
                                    ">
                                    {{ $category->icon }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $category->name }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-gray-900">{{ $category->formatted_balance }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="card-footer">
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-700">Total Saldo</span>
                    <span class="font-bold text-lg text-gray-900">{{ $formattedBalance }}</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.member>