<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Tags</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div id="alert-notification" class="mb-4 bg-indigo-100 border border-indigo-400 text-indigo-700 px-4 py-3 rounded-xl transition-opacity duration-500">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
                <form action="{{ route('tags.store') }}" method="POST" class="flex gap-4">
                    @csrf
                    <input type="text" name="name" placeholder="Tambah tag baru (misal: Tips)..." required
                           class="flex-1 border-gray-200 rounded-xl px-4 py-2 outline-none border focus:ring-2 focus:ring-indigo-500">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition-all">
                        Simpan Tag
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-sm">
                        <tr>
                            <th class="px-6 py-4">Nama Tag</th>
                            <th class="px-6 py-4">Digunakan di</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($tags as $tag)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">#{{ $tag->name }}</td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $tag->posts_count }} artikel</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Hapus tag ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('alert-notification');
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }
        });
    </script>
</x-app-layout>