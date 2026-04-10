<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Postingan - Emir Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
        <div class="flex items-center justify-between mb-8 border-b pb-6">
            <h1 class="text-3xl font-extrabold text-gray-900">Edit Postingan</h1>
            <a href="/dashboard" class="text-sm text-blue-600 hover:underline">← Kembali ke Dashboard</a>
        </div>

        <form action="/posts/{{ $post->slug }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Judul Blog</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                    class="w-full border border-gray-300 p-3 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all outline-none" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori</label>
                <select name="category_id" class="w-full border border-gray-300 p-3 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none appearance-none bg-no-repeat bg-right pr-10" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (old('category_id', $post->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select> </div>

            <div class="mb-6 p-5 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Foto Sampul</label>
                
                @if($post->image)
                <div class="mb-4 flex items-center gap-4">
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $post->image) }}" class="w-40 h-24 object-cover rounded-xl shadow-md border-2 border-white">
                        <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-white text-[10px] font-bold">Foto Saat Ini</span>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">
                        <p>Ingin ganti foto?</p>
                        <p class="italic text-gray-400">Pilih file baru di bawah ini.</p>
                    </div>
                </div>
                @endif

                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Tags Terkait</label>
                <div class="flex flex-wrap gap-4 p-4 bg-white border rounded-xl">
                    @foreach($tags as $tag)
                    <label class="inline-flex items-center cursor-pointer group">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            {{ $post->tags->contains($tag->id) ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-600 group-hover:text-blue-600 transition-colors">{{ $tag->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Isi Konten</label>
                <textarea name="body" rows="10"
                    class="w-full border border-gray-300 p-4 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none leading-relaxed" required>{{ old('body', $post->body) }}</textarea>
            </div>

            <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    Simpan Perubahan
                </button>
                <a href="/dashboard" class="text-gray-400 hover:text-gray-600 font-medium transition">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>