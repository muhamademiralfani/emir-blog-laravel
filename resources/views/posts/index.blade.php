<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emir Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 font-sans">

    <div class="max-w-4xl mx-auto py-10 px-4">
        <header class="flex justify-between items-center mb-10 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-600 tracking-tight">
                    <a href="/">Emir Blog</a>
                </h1>
                <p class="text-gray-500 text-sm">Tempat berbagi cerita dan inspirasi.</p>
            </div>

            <nav class="flex items-center gap-6">
                @auth
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                        Dashboard
                    </a>

                    <a href="/posts/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                        + Tulis
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium underline ml-2">
                            Keluar
                        </button>
                    </form>
                </div>
                @else
                @endauth
            </nav>

        </header>

        @if(isset($categoryName))
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">
                Kategori: <span class="text-blue-600">{{ $categoryName }}</span>
            </h1>
            <a href="/" class="text-sm text-gray-500 hover:text-blue-600">← Kembali ke semua artikel</a>
        </div>
        @endif

        <div class="mb-10 max-w-2xl mx-auto">
            <form action="{{ route('posts.index') }}" method="GET" class="relative group">
                <input
                    type="text"
                    id="search-input"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari artikel yang menarik..."
                    class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-100 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none text-gray-600">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                @if(request('search'))
                <a href="{{ route('posts.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-red-500 hover:underline font-bold">
                    Hapus Pencarian
                </a>
                @endif
            </form>

            @if(request('search'))
            <p class="mt-4 text-sm text-gray-500">
                Menampilkan hasil pencarian untuk: <span class="font-bold text-blue-600">"{{ request('search') }}"</span>
            </p>
            @endif
        </div>


        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl shadow-sm">
            {{ session('error') }}
        </div>
        @endif

        <div id="posts-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)

                <div class="bg-white rounded-2xl border border-gray-100 hover:border-indigo-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden">
                    <div class="relative overflow-hidden aspect-video">
                        @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $post->title }}">
                        @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">No Image</div>
                        @endif

                        <div class="absolute top-4 left-4">
                            <a href="{{ route('category.show', $post->category->slug) }}" class="backdrop-blur-md bg-white/70 text-indigo-700 text-[10px] font-bold px-3 py-1.5 rounded-full shadow-sm hover:bg-indigo-600 hover:text-white transition">
                                {{ $post->category->name ?? 'Article' }}
                            </a>
                        </div>
                    </div>

                    <div class="p-6">
                        <h2 class="text-xl font-bold text-slate-800 leading-tight mb-3 group-hover:text-indigo-600 transition-colors">
                            <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                        </h2>
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 mb-4">
                            {{ Str::limit(strip_tags($post->body), 90) }}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                    {{ substr($post->user->name ?? 'A', 0, 1) }}
                                </div>
                                <span class="text-xs font-medium text-slate-700">{{ $post->user->name ?? 'Admin' }}</span>
                            </div>
                            <span class="text-[11px] text-slate-400">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        </div>

        @if($posts->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100">
            <div class="mb-4 flex justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-gray-500 text-lg font-medium italic">Oops! Artikel "{{ request('search') }}" tidak ditemukan.</p>
            <a href="{{ route('posts.index') }}" class="mt-4 inline-block text-blue-600 font-bold hover:underline">Lihat semua artikel</a>
        </div>
        @endif



        @if($posts->isEmpty())
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg italic text-center">Belum ada postingan. Ayo nulis!</p>
        </div>
        @endif
    </div>

    <script>
        const searchInput = document.getElementById('search-input');
        const postsContainer = document.getElementById('posts-container');

        searchInput.addEventListener('keyup', function() {
            let keyword = searchInput.value;

            // Kirim permintaan ke server secara diam-diam (AJAX)
            fetch(`{{ route('posts.index') }}?search=${keyword}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Ambil hanya bagian artikel dari response, lalu tempel ke container
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newPosts = doc.getElementById('posts-container').innerHTML;
                    postsContainer.innerHTML = newPosts;
                });
        });
    </script>

</body>

</html>