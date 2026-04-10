<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;

use App\Http\Controllers\CommentController;
use App\Models\Comment;

// Route yang bisa diakses SEMUA ORANG (Tamu)
Route::get('/', [PostController::class, 'index'])->name('posts.index');

// Route yang cuma bisa diakses kalau sudah LOGIN (Admin)

Route::middleware('auth')->group(function () {
    // Route Blog yang sudah kamu buat tadi
    Route::get('/posts/create', [PostController::class, 'create']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post:slug}/edit', [PostController::class, 'edit']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // TAMBAHKAN INI (Route Profile bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. Route Detail (Show) - TARUH PALING BAWAH DI LUAR GRUP AUTH
// Gunakan {post:slug} agar Laravel tahu ini untuk pencarian berdasarkan slug
Route::get('/posts/{post:slug}', [PostController::class, 'show']);


// Pastikan ada 'admin' di dalam array middleware
Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    $search = $request->input('search');
    $query = \App\Models\Post::with('category')->latest();

    $posts = \App\Models\Post::with('category')
        ->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        })
        ->latest()
        ->get();
        
    // Hitung statistik
    $stats = [
        'total_posts' => Post::count(),
        'total_comments' => Comment::count(),
        'total_categories' => Category::count(),
    ];

    return view('dashboard', compact('posts', 'stats'));
})->middleware(['auth', 'admin'])->name('dashboard');

// Route bawaan Breeze (Login/Register)
require __DIR__ . '/auth.php';


Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');




Route::get('/category/{category:slug}', function (Category $category) {
    $posts = $category->posts()->with('category')->latest()->paginate(6)->withQueryString();

    return view('posts.index', [
        'posts' => $posts,
        'categoryName' => $category->name
    ]);
})->name('category.show');
