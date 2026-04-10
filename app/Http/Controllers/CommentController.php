<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // WAJIB TAMBAHKAN BARIS INI

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Gunakan Auth::check() (A-nya besar, pakai titik dua dua kali)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Login dulu ya!');
        }

        $request->validate([
            'user_name' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post->comments()->create([
            'user_name' => $request->user_name,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}