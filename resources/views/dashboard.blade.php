<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Postingan</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_posts'] }}</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Komentar</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_comments'] }}</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Kategori</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_categories'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Daftar Artikel</h1>
                    <a href="/posts/create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-semibold transition">
                        + Tambah Postingan Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Daftar Artikel</h2>

                        <form action="{{ route('dashboard') }}" method="GET" class="relative w-full md:w-80">
                            <input
                                type="text"
                                name="search"
                                id="dashboard-search"
                                value="{{ request('search') }}"
                                placeholder="Cari Artikel..."
                                class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 text-sm outline-none transition-all">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            @if(request('search'))
                            <a href="{{ route('dashboard') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                            @endif
                        </form>
                    </div>
                    <table id="dashboard-table" class="w-full text-left border-collapse">
                        <tbody class="divide-y divide-gray-200">
                            @forelse($posts as $post)
                            @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-gray-300 mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                        <p class="text-gray-500 italic">Artikel "{{ request('search') }}" tidak ditemukan.</p>
                                        <a href="{{ route('dashboard') }}" class="text-blue-600 text-sm mt-2 hover:underline">Reset Pencarian</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                            @forelse($posts as $index => $post)
                            <tr>
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-bold">{{ $post->title }}</td>
                                <td class="px-6 py-4">
                                    @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}"
                                        alt="{{ $post->title }}"
                                        class="w-16 h-12 object-cover rounded-md shadow-sm border border-gray-200">
                                    @else
                                    <div class="w-16 h-12 bg-gray-100 rounded-md flex items-center justify-center border border-dashed border-gray-300">
                                        <span class="text-[10px] text-gray-400 font-medium">No Image</span>
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $post->category->name ?? 'Tanpa Kategori' }}</td>
                                <td class="px-6 py-4 flex gap-4">
                                    <a href="/posts/{{ $post->slug }}/edit" class="text-yellow-600">Edit</a>
                                    <form action="/posts/{{ $post->slug }}" method="POST" onsubmit="return confirm('Yakin nih mau dihapus? Data nggak bisa balik lagi lho!')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada artikel. <a href="/posts/create" class="text-indigo-600 underline">Buat artikel pertama kamu!</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('dashboard-search');
        const tableContainer = document.getElementById('dashboard-table');

        searchInput.addEventListener('keyup', function() {
            let keyword = searchInput.value;

            // AJAX Request ke route dashboard
            fetch(`{{ route('dashboard') }}?search=${keyword}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Parsing HTML hasil fetch dan ambil bagian tabelnya saja
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTable = doc.getElementById('dashboard-table').innerHTML;

                    // Update isi tabel di halaman sekarang
                    tableContainer.innerHTML = newTable;
                });
        });
    </script>


</x-app-layout>