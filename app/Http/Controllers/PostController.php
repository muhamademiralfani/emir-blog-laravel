<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\View\View;
use Illuminate\Http\Request; // PASTIKAN BARIS INI ADA DAN BENAR
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        // Ambil keyword dari input search
        $search = $request->input('search');

        // Mengambil semua data postingan terbaru
        $posts = Post::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(6) // Ganti get() jadi paginate(6)
            ->withQueryString(); // Agar saat pindah halaman, keyword search tidak hilang


        // Mengirim data ke view posts/index.blade.php
        return view('posts.index', compact('posts'));
    }


    public function show(Post $post): View
    {
        // Laravel otomatis nyari postingan yang slug-nya pas
        return view('posts.show', compact('post'));
    }

    public function create(): View
    {
        $categories = Category::all(); // Ambil semua kategori
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:102000040', // Naikin jadi 10MB

        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder 'public/posts'
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'category_id' => $request->category_id, // Kategori baru
            'image' => $imagePath, // Simpan path-nya ke DB
        ]);

        // 3. Update data
        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'category_id' => $request->category_id, // Tambahkan ini agar kategori terupdate
            'image' => $imagePath,
        ]);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync([]);
        }


        return redirect()->route('dashboard')->with('success', 'Berhasil disimpan!');
    }



    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Artikel berhasil dihapus!');
    }


    public function edit(Post $post): View
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }



    public function update(Request $request, Post $post)
    {
        // 1. Validasi
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'tags' => 'nullable|array', // Validasi array tag
        ]);

        // 2. Update data
        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'category_id' => $request->category_id, // 2. INI KUNCINYA, jangan sampai terlewat!
        ]);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            // Kalau semua centang dihapus, bersihkan semua hubungan tag
            $post->tags()->sync([]);
        }

        // 3. Balik ke halaman detail atau home
        return redirect('/dashboard')->with('success', 'Postingan berhasil diperbarui!');
    }
}
