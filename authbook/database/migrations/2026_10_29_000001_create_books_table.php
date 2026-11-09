<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->unique();
            $table->string('title');
            $table->text('description')->nullable(); // Kolom deskripsi langsung kita masukkan ke sini
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->string('publisher')->nullable();
            $table->integer('year')->nullable();
            $table->string('cover')->nullable();
            $table->enum('status', ['available', 'borrowed'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};