<!DOCTYPE html>
<html lang="id">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 py-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Buat Postingan Baru</h1>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
                @endforeach

                @if ($errors->has('image'))
                <span class="text-red-500 text-sm">
                    Detail Error: {{ $errors->first('image') }}
                </span>
                @endif
            </ul>
        </div>
        @endif

        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-700 font-bold mb-2">Judul Blog</label>
                <input type="text" name="title" class="w-full border border-gray-300 p-3 rounded-lg" required>
                @error('title')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                <select name="category_id" class="w-full border border-gray-300 p-2 rounded-lg">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-bold mb-2">Foto Sampul (Thumbnail)</label>
                <input type="file" name="image" id="image" class="w-full border border-gray-300 p-2 rounded-lg bg-white">
                <p class="text-xs text-gray-400 mt-1">*Format: jpg, png, jpeg (Maks. 2MB)</p>
                @error('image')
                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-bold mb-2">Konten</label>
                <textarea name="body" rows="8" class="w-full border border-gray-300 p-3 rounded-lg" required></textarea>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-bold mb-2">Tags (Bisa pilih banyak)</label>
                <div class="flex flex-wrap gap-3">
                    @foreach($tags as $tag)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-gray-600">{{ $tag->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold">Simpan</button>
        </form>
    </div>
</body>

</html>