<x-layouts.admin :title="'Persetujuan Anggota'" :header="'Persetujuan Pendaftaran'">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-gray-600">Tinjau dan proses pendaftaran anggota baru</p>
        </div>
        <a href="{{ route('admin.members.index') }}" class="btn-secondary">
            ← Kembali ke Daftar
        </a>
    </div>

    <!-- Pending Members -->
    @if($members->count() > 0)
        <div class="space-y-4">
            @foreach($members as $member)
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                            <!-- Member Info -->
                            <div class="flex items-start gap-4 flex-1">
                                <div
                                    class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-700 font-bold text-xl flex-shrink-0">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg text-gray-900">{{ $member->name }}</h3>
                                    <p class="text-gray-500">{{ $member->email }}</p>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Telepon:</span>
                                            <span class="text-gray-900 ml-2">{{ $member->phone }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Gender:</span>
                                            <span class="text-gray-900 ml-2">{{ $member->gender?->label() ?? '-' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Tanggal Lahir:</span>
                                            <span
                                                class="text-gray-900 ml-2">{{ $member->birth_date?->format('d M Y') ?? '-' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Usia:</span>
                                            <span class="text-gray-900 ml-2">{{ $member->age ?? '-' }} tahun</span>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <span class="text-gray-500">Alamat:</span>
                                            <span class="text-gray-900 ml-2">{{ $member->address }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex items-center gap-2 text-xs text-gray-500">
                                        <span>📅</span>
                                        <span>Mendaftar {{ $member->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 lg:w-48">
                                <form action="{{ route('admin.members.approve', $member) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="btn-success w-full">
                                        ✓ Setujui
                                    </button>
                                </form>

                                <button type="button" onclick="showRejectModal({{ $member->id }}, '{{ $member->name }}')"
                                    class="btn-danger flex-1">
                                    ✕ Tolak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($members->hasPages())
            <div class="mt-6">
                {{ $members->links() }}
            </div>
        @endif
    @else
        <div class="card">
            <div class="card-body py-12 text-center">
                <div class="text-6xl mb-4">✅</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak Ada Pendaftaran Pending</h3>
                <p class="text-gray-500 mb-6">Semua pendaftaran sudah diproses</p>
                <a href="{{ route('admin.members.index') }}" class="btn-primary">
                    Lihat Semua Anggota
                </a>
            </div>
        </div>
    @endif

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 animate-fade-in">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tolak Pendaftaran</h3>
                <p class="text-gray-600 mb-4">Tolak pendaftaran <strong id="rejectName"></strong>?</p>

                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Alasan Penolakan (opsional)</label>
                        <textarea name="reason" rows="3" class="form-textarea"
                            placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="hideRejectModal()" class="btn-secondary flex-1">
                            Batal
                        </button>
                        <button type="submit" class="btn-danger flex-1">
                            Tolak Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showRejectModal(id, name) {
                document.getElementById('rejectName').textContent = name;
                document.getElementById('rejectForm').action = `/admin/members/${id}/reject`;
                document.getElementById('rejectModal').classList.remove('hidden');
            }

            function hideRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
            }

            // Close on escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') hideRejectModal();
            });

            // Close on backdrop click
            document.getElementById('rejectModal').addEventListener('click', function (e) {
                if (e.target === this) hideRejectModal();
            });
        </script>
    @endpush
</x-layouts.admin>