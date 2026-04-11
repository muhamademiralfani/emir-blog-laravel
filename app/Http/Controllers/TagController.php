<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        // withCount('posts') biar kita tahu tag mana yang paling populer
        $tags = Tag::withCount('posts')->get();
        return view('admin.tags', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:tags,name|max:30']);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return back()->with('success', 'Tag baru berhasil ditambahkan!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag berhasil dihapus!');
    }
}
