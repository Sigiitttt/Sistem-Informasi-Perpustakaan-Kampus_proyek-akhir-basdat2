<x-filament-panels::page>
    {{-- Form Filter Tanggal --}}
    <form wire:submit="submit" class="mb-6">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Buat Laporan
        </x-filament::button>
    </form>

    @php
        $reportData = $this->getReportData();
    @endphp

    {{-- Tampilkan card statistik --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Laporan Periode: {{ $reportData['startDate'] }} - {{ $reportData['endDate'] }}
        </h2>

        <div class="mt-4 text-2xl font-bold text-gray-900 dark:text-gray-100">
            Total Peminjaman: {{ $reportData['totalLoans'] }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                Top 5 Buku Terpopuler
            </h3>
            <ul class="space-y-2">
                @forelse ($reportData['popularBooks'] as $item)
                    {{-- PERBAIKAN DI BARIS DI BAWAH INI --}}
                    <li class="flex justify-between items-center text-sm text-white-700 dark:text-gray-300">
                        <span>{{ $loop->iteration }}. {{ $item->buku->judul ?? 'Buku Dihapus' }}</span>
                        <span class="font-bold bg-amber-500 text-white px-2 py-1 rounded-full text-xs">{{ $item->total }} kali</span>
                    </li>
                @empty
                    <li class="text-gray-500 dark:text-gray-400">Tidak ada data peminjaman pada periode ini.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
             <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                Top 5 Anggota Teraktif
            </h3>
             <ul class="space-y-2">
                @forelse ($reportData['activeMembers'] as $member)
                    {{-- PERBAIKAN DI BARIS DI BAWAH INI --}}
                    <li class="flex justify-between items-center text-sm text-white-700 dark:text-gray-300">
                        <span>{{ $loop->iteration }}. {{ $member->name }}</span>
                        <span class="font-bold bg-blue-500 text-white px-2 py-1 rounded-full text-xs">{{ $member->total_pinjam }} buku</span>
                    </li>
                @empty
                    <li class="text-white-500 dark:text-gray-400">Tidak ada data peminjaman pada periode ini.</li>
                @endforelse
            </ul>
        </div>
    </div>

</x-filament-panels::page>