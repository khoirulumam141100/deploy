<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Kauman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white;
            }

            .print-container {
                padding: 0;
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen text-gray-900 font-sans">

    <!-- Screen Only Header / Controls -->
    <div class="no-print bg-white shadow-sm border-b border-gray-200 p-4 sticky top-0 z-10">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.finance.index') }}"
                    class="text-gray-500 hover:text-gray-700 flex items-center gap-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <h1 class="text-lg font-bold text-gray-900 border-l border-gray-300 pl-3">Mode Cetak Laporan</h1>
            </div>

            <form action="{{ route('admin.finance.report') }}" method="GET" class="flex items-center gap-2">
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="px-3 py-1.5 border border-gray-300 rounded-md text-sm">
                <span class="text-gray-500">-</span>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="px-3 py-1.5 border border-gray-300 rounded-md text-sm">
                <button type="submit"
                    class="bg-green-600 text-white px-3 py-1.5 rounded-md text-sm hover:bg-green-700">Filter</button>
            </form>

            <button onclick="window.print()"
                class="bg-gray-900 text-white px-4 py-2 rounded-md flex items-center gap-2 hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Report Paper -->
    <div class="print-container max-w-5xl mx-auto bg-white p-8 md:p-12 my-8 shadow-lg print:shadow-none print:my-0">

        <!-- Kop Surat -->
        <div class="flex items-center justify-between border-b-2 border-gray-900 pb-6 mb-8">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Kauman" class="w-16 h-16 rounded-lg object-contain">
                <div>
                    <h1 class="text-2xl font-bold uppercase tracking-wide">DUSUN KAUMAN</h1>
                    <p class="text-sm text-gray-600">Desa Deras, Kecamatan Ledokombo, Kabupaten Jember</p>
                    <p class="text-xs text-gray-500 mt-1">Sistem Informasi Komunitas RT/RW</p>
                    </p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-900">LAPORAN KEUANGAN</h2>
                <p class="text-sm text-gray-600">Periode: {{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y') }}
                    - {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y') }}</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 print:border-gray-300">
                <p class="text-sm text-gray-500 mb-1">Total Pemasukan</p>
                <p class="text-xl font-bold text-green-700">Rp
                    {{ number_format($summary['total_income'], 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 print:border-gray-300">
                <p class="text-sm text-gray-500 mb-1">Total Pengeluaran</p>
                <p class="text-xl font-bold text-red-700">Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 print:border-gray-300">
                <p class="text-sm text-gray-500 mb-1">Selisih (Net)</p>
                <p class="text-xl font-bold text-gray-700">
                    {{ $summary['net_change'] >= 0 ? '+' : '' }}Rp
                    {{ number_format($summary['net_change'], 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Transactions Table -->
        <table class="w-full text-sm text-left mb-8 border-collapse">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold print:bg-gray-200">
                <tr>
                    <th class="px-4 py-3 border border-gray-300 w-12 text-center">No</th>
                    <th class="px-4 py-3 border border-gray-300 w-32">Tanggal</th>
                    <th class="px-4 py-3 border border-gray-300">Keterangan</th>
                    <th class="px-4 py-3 border border-gray-300 w-32">Kategori</th>
                    <th class="px-4 py-3 border border-gray-300 w-24 text-center">Tipe</th>
                    <th class="px-4 py-3 border border-gray-300 w-32 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions as $index => $transaction)
                    <tr class="hover:bg-gray-50 print:hover:bg-transparent">
                        <td class="px-4 py-2 border border-gray-300 text-center text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-gray-600 whitespace-nowrap">
                            {{ $transaction->transaction_date->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2 border border-gray-300 text-gray-900">
                            {{ $transaction->description }}
                            <div class="text-xs text-gray-400 mt-0.5 print:hidden">oleh: {{ $transaction->user->name }}
                            </div>
                        </td>
                        <td class="px-4 py-2 border border-gray-300 text-gray-600">
                            {{ $transaction->category->name }}
                        </td>
                        <td class="px-4 py-2 border border-gray-300 text-center">
                            @if($transaction->type->value === 'income')
                                <span
                                    class="print:hidden bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full font-medium">Masuk</span>
                                <span class="hidden print:inline text-green-700 font-bold">+</span>
                            @else
                                <span
                                    class="print:hidden bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded-full font-medium">Keluar</span>
                                <span class="hidden print:inline text-red-700 font-bold">-</span>
                            @endif
                        </td>
                        <td
                            class="px-4 py-2 border border-gray-300 text-right font-medium {{ $transaction->type->value === 'income' ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500 border border-gray-300">
                            Tidak ada data transaksi pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 font-bold print:bg-gray-100">
                    <td colspan="5" class="px-4 py-3 border border-gray-300 text-right uppercase text-xs">Total Akhir
                    </td>
                    <td class="px-4 py-3 border border-gray-300 text-right text-base text-gray-900">
                        {{ $summary['net_change'] >= 0 ? '+' : '' }}Rp
                        {{ number_format($summary['net_change'], 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Signatures -->
        <div class="grid grid-cols-2 gap-8 mt-16 page-break-inside-avoid">
            <div class="text-center">
                <p class="mb-20">Mengetahui,<br>Kepala Dusun</p>
                <div class="border-b border-gray-900 w-48 mx-auto mb-2"></div>
                <p class="font-bold">( .................................... )</p>
            </div>
            <div class="text-center">
                <p class="mb-20">Kayong Utara, {{ now()->isoFormat('D MMMM Y') }}<br>Bendahara</p>
                <div class="border-b border-gray-900 w-48 mx-auto mb-2"></div>
                <p class="font-bold">{{ auth()->user()->name }}</p>
            </div>
        </div>

        <!-- Printing Footer -->
        <div class="mt-12 text-center text-xs text-gray-400 print:text-gray-500">
            Dicetak oleh sistem Kauman pada {{ now()->format('d/m/Y H:i') }} WIB
        </div>

    </div>

</body>

</html>