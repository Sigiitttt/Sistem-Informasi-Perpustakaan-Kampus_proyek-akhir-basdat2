   <x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
{{ __('Detail Buku') }}
</h2>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <div class="md:col-span-1">
                            <img src="{{ $buku->gambar_cover ? asset('storage/' . $buku->gambar_cover) : 'https://via.placeholder.com/400x600.png?text=No+Image' }}" 
                                 alt="Cover {{ $buku->judul }}" 
                                 class="w-full h-auto object-cover rounded-lg shadow-md">
                        </div>

                        <div class="md:col-span-2 text-gray-800 dark:text-gray-200">
                            <h1 class="text-3xl font-bold mb-2">{{ $buku->judul }}</h1>
                            <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">oleh {{ $buku->penulis }}</p>

                            <div class="mb-6">
                                <h3 class="font-semibold text-lg border-b border-gray-200 dark:border-gray-700 pb-2 mb-3">Deskripsi</h3>
                                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $buku->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                            </div>
                            
                            <div class="mb-6">
                                 <h3 class="font-semibold text-lg border-b border-gray-200 dark:border-gray-700 pb-2 mb-3">Detail Informasi</h3>
                                 <ul class="space-y-2 text-sm">
                                    <li class="flex justify-between"><span class="font-semibold text-gray-500">ISBN:</span> <span>{{ $buku->isbn }}</span></li>
                                    <li class="flex justify-between"><span class="font-semibold text-gray-500">Penerbit:</span> <span>{{ $buku->penerbit }}</span></li>
                                    <li class="flex justify-between"><span class="font-semibold text-gray-500">Tahun Terbit:</span> <span>{{ $buku->tahun_terbit }}</span></li>
                                    <li class="flex justify-between"><span class="font-semibold text-gray-500">Kategori:</span> <span>{{ $buku->kategori->nama_kategori ?? 'N/A' }}</span></li>
                                    <li class="flex justify-between"><span class="font-semibold text-gray-500">Lokasi Rak:</span> <span>{{ $buku->rak->nama_rak ?? 'N/A' }}</span></li>
                                 </ul>
                            </div>

                            <div class="mt-8">
                                <p class="text-lg font-bold mb-4 {{ $buku->jumlah_stok > 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $buku->jumlah_stok > 0 ? 'Tersedia' : 'Stok Habis' }} (Stok: {{ $buku->jumlah_stok }})
                                </p>

                                @if ($buku->jumlah_stok > 0)
                                    <form action="{{ route('books.borrow', $buku) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                            Pinjam Buku Ini
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="w-full px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed" disabled>
                                        Stok Habis
                                    </button>
                                @endif
                                <a href="{{ route('books.index') }}" class="block text-center mt-4 text-sm text-indigo-500 hover:underline">
                                    &larr; Kembali ke Katalog
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>