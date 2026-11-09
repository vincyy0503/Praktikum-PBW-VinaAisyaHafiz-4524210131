<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil Seeder untuk Role
        $this->call([
            UserRoleSeeder::class,
        ]);

        // Buat data Author & Book
        $authors = Author::factory(10)->create();
        Book::factory(50)->create([
            'author_id' => fn() => $authors->random()->id,
        ]);

        // Panggil Seeder untuk Kategori (kalau sudah kamu buat)
        $this->call([
            CategorySeeder::class,
        ]);
    }
}