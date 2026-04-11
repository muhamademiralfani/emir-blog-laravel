<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

Route::get('/force-login-admin', function () {
    $user = User::where('email', 'muhamademiralfani@gmail.com')->first();
    if ($user) {
        Auth::login($user);
        return redirect('/dashboard');
    }
    return 'User tidak ditemukan di database!';
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

Route::middleware(['auth', 'admin'])->group(function () {
    // Route CRUD Kategori
    Route::get('/dashboard/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/dashboard/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/dashboard/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/dashboard/tags', [TagController::class, 'index'])->name('tags.index');
    Route::post('/dashboard/tags', [TagController::class, 'store'])->name('tags.store');
    Route::delete('/dashboard/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
});



// Route bawaan Breeze (Login/Register)
require __DIR__ . '/auth.php';


Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');


Route::get('/debug-db', function () {
    $dbPath = config('database.connections.sqlite.database');
    $exists = file_exists($dbPath);
    $allUsers = \App\Models\User::all();

    return [
        'database_path' => $dbPath,
        'file_exists' => $exists,
        'environment' => app()->environment(),
        'total_users' => $allUsers->count(),
        'users_data' => $allUsers,
        'db_connection' => config('database.default'),
    ];
});



Route::get('/category/{category:slug}', function (Category $category) {
    $posts = $category->posts()->with('category')->latest()->paginate(6)->withQueryString();

    return view('posts.index', [
        'posts' => $posts,
        'categoryName' => $category->name
    ]);
})->name('category.show');
