<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Katalog Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <form action="{{ route('books.index') }}" method="GET">
                    <div class="flex">
                        <input type="text" name="search" placeholder="Cari berdasarkan judul atau penulis..." 
                            class="w-full rounded-l-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                            value="{{ request('search') }}">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-r-md hover:bg-indigo-700">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($books as $book)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">

                        <a href="{{ route('books.show', $book) }}">
                            {{-- PERUBAHAN UTAMA DI SINI --}}
                            <div class="aspect-w-3 aspect-h-4 bg-gray-200 dark:bg-gray-700">
                                <img src="{{ $book->gambar_cover ? asset('storage/' . $book->gambar_cover) : 'https://via.placeholder.com/300x400.png?text=No+Image' }}" alt="Cover {{ $book->judul }}" class="w-full h-full object-cover">
                            </div>
                        </a>

                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100" title="{{ $book->judul }}">{{ Str::limit($book->judul, 45) }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $book->penulis }}</p>

                            <p class="text-sm font-bold mt-auto pt-2 {{ $book->jumlah_stok > 0 ? 'text-green-500' : 'text-red-500' }}">
                                {{ $book->jumlah_stok > 0 ? 'Tersedia' : 'Stok Habis' }} (Stok: {{ $book->jumlah_stok }})
                            </p>
                        </div>

                        <div class="p-4 pt-0">
                            @if ($book->jumlah_stok > 0)
                                <form action="{{ route('books.borrow', $book) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Pinjam Buku
                                    </button>
                                </form>
                            @else
                                <button type="button" class="w-full px-4 py-2 bg-gray-400 text-white font-semibold rounded-lg text-sm cursor-not-allowed" disabled>
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-gray-600 dark:text-gray-400">Tidak ada buku yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $books->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-app-layout>