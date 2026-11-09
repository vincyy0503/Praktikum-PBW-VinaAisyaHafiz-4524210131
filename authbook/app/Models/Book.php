<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // ▼ TAMBAHAN TUGAS 2 ▼

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'description', // ▼ TAMBAHAN TUGAS 2 ▼
        'author_id',
        'publisher',
        'year',
        'cover',
        'status',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    // ▼ TAMBAHAN TUGAS 2 (Relasi Kategori) ▼
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}