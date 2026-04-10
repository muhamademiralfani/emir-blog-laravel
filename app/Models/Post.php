<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Ini wajib ada agar kolom bisa diisi
    protected $fillable = ['title', 'slug', 'body', 'image', 'category_id']; // 'image' HARUS ADA DI SINI

    public function category()
    {
        return $this->belongsTo(Category::class); // Postingan "milik" satu Kategori
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
