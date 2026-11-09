<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // <--- PASTIKAN BARIS INI ADA

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}