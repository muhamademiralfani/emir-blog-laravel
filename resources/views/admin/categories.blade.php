<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div id="alert-notification" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl transition-opacity duration-500">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
                <form action="{{ route('categories.store') }}" method="POST" class="flex flex-col md:flex-row gap-4">
                    @csrf
                    <input type="text" name="name" placeholder="Nama kategori baru (misal: Coding)..." required
                        class="flex-1 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 px-4 py-2 outline-none border transition-all">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition-all">
                        Tambah Kategori
                    </button>
                </form>
                @error('name')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-sm font-semibold">
                        <tr>
                            <th class="px-6 py-4">Nama Kategori</th>
                            <th class="px-6 py-4">Jumlah Artikel</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($categories as $cat)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $cat->name }}</td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $cat->posts_count }} artikel</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Yakin mau hapus kategori ini? Artikel di dalamnya mungkin akan kehilangan kategori.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 font-bold text-sm transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline text-sm font-medium">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

</x-app-layout>
<script>
    // Tunggu sampai halaman selesai loading
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('alert-notification');

        if (alert) {
            // Set waktu 3000ms (3 detik) sebelum mulai menghilang
            setTimeout(() => {
                // Tambahkan efek transisi biar halus
                alert.style.opacity = '0';

                // Setelah efek transisi selesai (sekitar 500ms), hapus elemen dari layar
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 3000);
        }
    });
</script>