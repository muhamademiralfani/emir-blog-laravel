<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Tambahkan baris ini biar Laravel ijinin kamu masukin data lewat Tinker/Form
    protected $fillable = ['name', 'slug'];

    // Relasi ke Post (Satu kategori punya banyak postingan)
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
