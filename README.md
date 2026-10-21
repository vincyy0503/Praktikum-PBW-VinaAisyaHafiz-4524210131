<div align="center">

# **LAPORAN PRAKTIKUM PERTEMUAN 6**  
## **PEMROGRAMAN BERBASIS WEB (A)**

<img width="300" height="291" alt="image" src="https://github.com/user-attachments/assets/c8ff510d-7d09-48c7-bca9-d70fab465d65" />


Disusun Oleh:  
**Vina Aisya Hafiz**  
**4524210131**

**Dosen:**  
Bambang Riono Arsad, S.Kom., MMSI 

**S1-TEKNIK INFORMATIKA**  
**FAKULTAS TEKNIK UNIVERSITAS PANCASILA**  
**2026/2027**
</div>

# **NOTICE!**
> ### Laporan Minggu sebelummnya berada di Folder bernama(Laprak-pbw)
# **1. Preparation**
```markdown
# Modul Praktikum: Filament & Laravel

Panduan praktikum ini dibuat untuk membangun aplikasi web berbasis Laravel dan Filament.

---

## 🚀 BAGIAN 1: Setup Project Laravel (30 menit)

### 1.1 Membuat Project Laravel Baru

```bash
composer create-project laravel/laravel bookstore
cd bookstore
php artisan serve

```

Penjelasan:

* `composer create-project`: membuat project Laravel baru
* `cd bookstore`: masuk direktori project
* Akses aplikasi di: `http://localhost:8000`
* Checkpoint: Halaman Laravel Welcome muncul

### 1.2 Konfigurasi Database (SQLite)

Buat file database kosong:

```bash
touch database/database.sqlite

```

Edit file `.env`:

```env
DB_CONNECTION=sqlite

```

Penjelasan:
SQLite adalah database berbasis file - tidak memerlukan instalasi server.

Alternatif (MySQL):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookstore
DB_USERNAME=root
DB_PASSWORD=

```

### 1.3 Install Filament

```bash
composer require filament/filament:"^3.0"
php artisan filament:install --panels

```

Checkpoint:

* File `AdminPanelProvider.php` muncul di `app/Providers/Filament/`

---

## 📦 BAGIAN 2: Model & Database (45 menit)

### 2.1 Membuat Model Author

```bash
php artisan make:model Author -m

```

### 2.2 Migration Author

Edit file migration:

```php
Schema::create('authors', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});

```

### 2.3 Membuat Model Book

```bash
php artisan make:model Book -m

```

### 2.4 Migration Book

Edit file migration:

```php
Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->foreignId('author_id')->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->string('isbn')->unique();
    $table->text('description')->nullable();
    $table->integer('year');
    $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
    $table->string('cover_image')->nullable();
    $table->timestamps();
});

```

### 2.5 Edit Model Author

```php
class Author extends Model
{
    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

```

### 2.6 Edit Model Book

```php
class Book extends Model
{
    protected $fillable = [
        'author_id', 'title', 'isbn', 'description', 'year', 'status', 'cover_image'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}

```

### 2.7 Jalankan Migration

```bash
php artisan migrate
php artisan migrate:status

```

---

## 🌾 BAGIAN 3: Factory & Seeder (30 menit)

### 3.1 Factory Author

```bash
php artisan make:factory AuthorFactory

```

```php
return [
    'name' => fake()->name()
];

```

### 3.2 Factory Book

```bash
php artisan make:factory BookFactory

```

```php
return [
    'title' => fake()->sentence(3),
    'isbn' => fake()->isbn13(),
    'description' => fake()->paragraph(),
    'year' => fake()->year(),
    'status' => fake()->randomElement(['draft', 'published', 'archived']),
];

```

### 3.3 Seeder

```php
User::factory()->create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
]);

$authors = Author::factory(10)->create();

foreach ($authors as $author) {
    Book::factory(rand(2, 5))->create([
        'author_id' => $author->id,
    ]);
}

```

### 3.4 Storage Link

```bash
php artisan storage:link

```

### 3.5 Fresh + Seed

```bash
php artisan migrate:fresh --seed

```

---

## 🧩 BAGIAN 4: Filament Resources (60 menit)

### 4.1 Author Resource

```bash
php artisan make:filament-resource Author --generate

```

### 4.2 Kustomisasi Author Resource

Menggunakan:

* TextInput
* Counts relation
* Sorting & Searching

### 4.3 Book Resource

```bash
php artisan make:filament-resource Book --generate --view

```

Termasuk:

* ISBN unik
* Relasi Author
* File Upload Cover
* Filtering (year, status, author)
* Badge Column

### 4.4 Kustomisasi View Book Page

Menggunakan:

* Infolist
* ImageEntry
* Badge
* Copyable

---

## 🔒 BAGIAN 5: Authorization (30 menit)

### 5.1 Book Policy

```bash
php artisan make:policy BookPolicy --model=Book

```

Isi default semua `true`.

### 5.2 Author Policy

```bash
php artisan make:policy AuthorPolicy --model=Author

```

Isi default semua `true`.

---

## 👤 BAGIAN 6: Admin User & Testing (30 menit)

### 6.1 Membuat Admin

```bash
php artisan make:filament-user

```

### 6.2 Login Panel

Akses:

```
http://localhost:8000/admin

```

### 6.3 Testing CRUD

* Create Book
* Search
* Filter
* Edit
* Delete
* Bulk Delete
* View Detail

---

## 🛠️ BAGIAN 7: Verifikasi & Debug (15 menit)

### 7.1 Cek Routes

```bash
php artisan route:list --path=admin

```

### 7.2 Cek Data

```bash
php artisan tinker

```

```php
Author::count();
Book::count();

```

### 7.3 Clear Cache

```bash
php artisan optimize:clear

```

---

## 📝 Tugas & Evaluasi

Tugas 1 (40 poin)

* 1. Halaman Autentikasi (Login)
Aplikasi telah berhasil mengimplementasikan sistem autentikasi. Halaman login menampilkan antarmuka standar Filament dengan input form untuk Email address dan Password, di mana login berhasil dilakukan menggunakan akun terdaftar dengan email vina@gmail.com
<img width="831" height="657" alt="Screenshot 2026-10-20 205825" src="https://github.com/user-attachments/assets/85f3a3bb-e67d-4660-bc68-05e4ec45aacb" />

* 2. Dashboard Admin Panel
Setelah berhasil login, sistem mengarahkan pengguna ke panel admin Filament yang memuat pesan selamat datang ("Welcome Vina"). Antarmuka ini dilengkapi sidebar navigasi di sisi kiri yang berisi grup menu Library Management dengan dua modul utama: Authors dan Books. Panel ini juga mengonfirmasi penggunaan framework Filament.
<img width="1917" height="751" alt="Screenshot 2026-10-20 200655" src="https://github.com/user-attachments/assets/50fa03f0-6105-4619-aee1-965e5238f96d" />

* 3. Modul Manajemen Buku (Books Resource)
Halaman daftar buku menampilkan implementasi tabel interaktif dari Filament Resources. Data buku telah berhasil digenerate menggunakan Factory dan Seeder, lalu ditampilkan dengan lengkap.
<img width="1893" height="916" alt="image" src="https://github.com/user-attachments/assets/55bcc9cd-4b63-4937-a419-e340c9e2de28" />

* 4. Halaman Create Books
Halaman Create Book menampilkan implementasi antarmuka input data menggunakan komponen Forms dari Filament.
<img width="1893" height="917" alt="image" src="https://github.com/user-attachments/assets/9d1b0f48-999d-4e35-843e-88d34f75d36e" />

* 5. Halaman Detail Buku (Infolist)
Halaman View Book membuktikan keberhasilan implementasi fitur Infolists pada Filament untuk menampilkan detail data secara terstruktur dan read-only. Halaman ini memuat Cover gambar buku di sisi kiri, berdampingan dengan informasi spesifik seperti ISBN, Title (dicetak tebal), Author (hasil relasi database), Publisher, Year, serta Status.
<img width="1901" height="906" alt="image" src="https://github.com/user-attachments/assets/ba706b15-3ca2-428b-9334-a3c5ccb656e3" />

* 6. Modul Manajemen Penulis (Authors Resource)
Halaman Authors mengelola entitas penulis dan memvalidasi keberhasilan implementasi relasi One-to-Many antar model.
Tabel daftar penulis menampilkan kolom Books yang menghitung total buku dari setiap penulis secara otomatis menggunakan fungsi agregat relasi (counts).
<img width="1896" height="911" alt="image" src="https://github.com/user-attachments/assets/474c4ddb-b354-47cd-96f1-13648c2e0bfe" />

* Halaman Create Author menampilkan Forms component dari Filament berupa TextInput sederhana untuk menginput nama penulis baru ke dalam database. 
<img width="1917" height="922" alt="image" src="https://github.com/user-attachments/assets/de74c311-061f-4e71-a78c-ea9bdb39c733" />

* 7. Menu Pengguna dan Tema (User Menu)
Aplikasi menampilkan dropdown menu profil di sudut kanan atas untuk pengguna aktif ("Vina"). Menu ini mencakup tombol Sign out untuk keluar dari sesi, serta toggle bawaan Filament untuk mengubah tampilan tema panel (Light Mode, Dark Mode, atau mengikuti preferensi sistem).
<img width="316" height="227" alt="image" src="https://github.com/user-attachments/assets/e4d0efae-6013-4328-8589-50b81579aa10" />

```

```
