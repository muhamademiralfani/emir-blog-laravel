<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Emir Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-900 font-sans">

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
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium text-sm">Login</a>
                    <a href="{{ route('register') }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-900 transition">Daftar</a>
                </div>
                @endauth
            </nav>
        </header>

        <article class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="mb-6">
                <a href="{{ route('category.show', $post->category->slug) }}" class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase">
                    {{ $post->category->name ?? 'Article' }}
                </a>

            </div>

            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">{{ $post->title }}</h1>

            <div class="flex items-center gap-3 text-gray-400 text-sm mb-8">
                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold border border-blue-100">
                    {{ substr($post->user->name ?? 'A', 0, 1) }}
                </div>
                <span>Oleh <span class="font-semibold text-gray-700">{{ $post->user->name ?? 'Admin' }}</span></span>
                <span>•</span>
                <span>{{ $post->created_at->format('d F Y') }}</span>
            </div>

            @if($post->image)
            <div class="mb-8 -mx-8"> <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-auto max-h-[500px] object-cover">
            </div>
            @endif

            <div class="prose max-w-none text-gray-700 leading-relaxed text-lg whitespace-pre-line">
                {{ $post->body }}
            </div>

            @if($post->tags->count() > 0)
            <div class="mt-10 pt-6 border-t border-gray-100">
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                    <span class="text-sm text-blue-600 bg-blue-50 px-3 py-1 rounded-md">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </article>

        <div class="mt-12">
            <h3 class="text-2xl font-bold mb-8 text-gray-800 flex items-center gap-2">
                💬 Komentar
                <span class="bg-gray-200 text-gray-600 text-sm px-2 py-0.5 rounded-full">{{ $post->comments->count() }}</span>
            </h3>

            <div class="space-y-4 mb-10">
                @forelse($post->comments as $comment)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <p class="font-bold text-gray-900">{{ $comment->user_name }}</p>
                        <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->body }}</p>
                </div>
                @empty
                <p class="text-center text-gray-400 italic py-5">Belum ada komentar. Jadi yang pertama berkomentar!</p>
                @endforelse
            </div>

            <div class="bg-blue-50 p-8 rounded-3xl border border-blue-100 shadow-sm">
                <h3 class="text-lg font-bold mb-4 text-blue-900">Tulis Komentar</h3>

                @auth
                <form action="{{ route('comments.store', $post->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-blue-400 uppercase tracking-wider mb-2">Nama Kamu</label>
                        <input type="text" name="user_name" value="{{ auth()->user()->name }}"
                            class="w-full border-blue-200 rounded-xl shadow-sm bg-white/50 focus:border-blue-500 focus:ring-blue-500" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-blue-400 uppercase tracking-wider mb-2">Isi Komentar</label>
                        <textarea name="body" rows="4" placeholder="Apa pendapatmu tentang artikel ini?"
                            class="w-full border-blue-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-md shadow-blue-200">
                        Kirim Komentar
                    </button>
                </form>
                @else
                <div class="text-center py-4">
                    <p class="text-blue-800 font-medium mb-4">Ingin ikut berdiskusi? Login dulu yuk!</p>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-700 transition">
                        Login Sekarang
                    </a>
                </div>
                @endauth
            </div>
        </div>

    </div>
</body>

</html>