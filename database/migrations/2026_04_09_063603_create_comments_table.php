<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // foreignId untuk menyambungkan ke tabel posts
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('user_name'); // Nama orang yang komen
            $table->text('body');       // Isi komentarnya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
