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

# BAGIAN 2 – Dokumentasi Tampilan Aplikasi

## 1. Halaman Dashboard (Admin)

Halaman dashboard ini merupakan tampilan utama setelah admin berhasil login ke panel Filament. Pada bagian atas terdapat *Welcome card* yang menampilkan identitas user yang sedang login (Admin User) beserta tombol **Sign out**. Di sisi kanan terdapat kartu informasi Filament v3.3.57 dengan tautan dokumentasi dan GitHub.

Terdapat empat widget statistik yang dibuat pada Tugas 2 poin 3, yaitu:

- **Total Books: 51**: jumlah seluruh buku dalam database (hasil seeder 50 buku + 1 buku yang ditambahkan manual saat testing).
- **Total Authors: 11**: jumlah seluruh penulis (10 dari seeder + 1 author baru yang dibuat inline melalui form Book).
- **Books Available: 31**: jumlah buku berstatus *available*.
- **Books Borrowed: 20**: jumlah buku berstatus *borrowed*.

> <img width="1892" height="892" alt="Screenshot 2026-11-03 122721" src="https://github.com/user-attachments/assets/23b294f9-1a2e-4350-bb5a-242c2422f073" />


## 2. Daftar Authors (Admin)

Tampilan tabel manajemen data penulis (*Authors*) khusus Admin. Menampilkan daftar *Author* dengan kolom **ID**, **Name**, dan jumlah **Books**. Sebagai Admin, tombol aksi di sebelah kanan mencakup tombol **Edit** dan **Delete** untuk pengelolaan penuh terhadap data *Author*.

><img width="1891" height="888" alt="Screenshot 2026-11-09 165648" src="https://github.com/user-attachments/assets/d21538bf-fe44-428c-91fb-42d3b6fe59bd" />


## 3. Detail & Edit Author (Admin)

**View Author:** Menampilkan informasi detail nama *Author* secara *read-only* dalam bentuk *modal popup*.

> <img width="1120" height="410" alt="Screenshot 2026-11-09 165423" src="https://github.com/user-attachments/assets/85b55028-7f55-4628-b568-cce6417bff79" />


**Edit Author:** Form pengubahan data *Author* tempat Admin dapat memperbarui nama penulis, menyimpan perubahan via tombol *Save changes*, atau menghapus data menggunakan tombol *Delete* berlatar merah.

> <img width="1916" height="547" alt="Screenshot 2026-11-09 165717" src="https://github.com/user-attachments/assets/0e0531f1-4251-4420-9c8c-f2b873d893a4" />


## 4. Daftar Books (Admin)

Menampilkan daftar buku lengkap dengan atribut Cover, ISBN, Title, Author, Categories, Publisher, Year, Status, serta *Created at*. Pada setiap baris data, Admin memiliki akses tindakan penuh berupa **View**, **Edit**, dan **Delete**.

> <img width="1886" height="877" alt="Screenshot 2026-11-09 163630" src="https://github.com/user-attachments/assets/147b8bc7-a528-4908-89ac-768874a04618" />


## 5. Edit Book & Form Upload Cover (Admin)

Admin dapat mengubah informasi mendasar seperti ISBN, Title, Description, Author, Publisher, Year, Status, dan Categories. Bagian *Cover Image* menyertakan fitur *FileUpload* yang memproses pemuatan (*loading*) dan pratinjau berkas gambar sampul buku.

> <img width="1897" height="891" alt="Screenshot 2026-11-09 163834" src="https://github.com/user-attachments/assets/8fd5b8c1-f4dc-4436-aad3-3388e56ba4d3" />


## 6. View Book Detail (Admin)

Memanfaatkan komponen *Infolist* Filament untuk menampilkan detail data secara terstruktur (Gambar Cover, Judul, ISBN, Author, Publisher, Status, Year, Categories, serta Description). Pada bagian pojok kanan atas, tersedia tombol **Delete** bagi Admin jika ingin menghapus buku tersebut.

> <img width="1896" height="901" alt="Screenshot 2026-11-09 164252" src="https://github.com/user-attachments/assets/3c24090d-25e1-47e5-8c59-0b44a6551ba9" />


## 7. Dashboard (Staff)

Menampilkan ucapan selamat datang untuk **Staff User**. Informasi statistik (Total Books, Total Authors, Books Available, Books Borrowed) serta grafik *Book Status Distribution* ditampilkan serupa dengan tampilan Admin untuk pemantauan data.

> <img width="1887" height="907" alt="Screenshot 2026-11-09 170633" src="https://github.com/user-attachments/assets/a4477b27-1d71-4cf0-8934-38ebe1d27002" />


## 8. Daftar Authors (Staff)

Berdasarkan aturan *Policy* hak akses, Staff diizinkan menambah data (*New author*) dan mengubah data. Opsi aksi pada tabel hanya menampilkan tombol **View** dan **Edit**, tanpa adanya tombol *Delete* langsung di tabel utama.

> <img width="1882" height="888" alt="Screenshot 2026-11-09 170733" src="https://github.com/user-attachments/assets/8f1bf14e-48b6-4137-80fb-e70d42663e7f" />


## 9. Edit Author (Staff)

Menampilkan form *Edit Author* di mana Staff dapat mengubah nama *Author* dan menyimpannya. Berbeda dengan tampilan Admin, halaman *Edit Author* milik Staff tidak dilengkapi dengan tombol *Delete*.

> <img width="1886" height="542" alt="Screenshot 2026-11-09 170948" src="https://github.com/user-attachments/assets/07a36955-9105-441d-b17a-f32f67279708" />


## 10. Daftar Books (Staff)

Staff memiliki tombol **New book** untuk menambahkan data buku baru. Aksi untuk setiap baris buku dibatasi hanya pada **View** dan **Edit** (akses *Delete* dibatasi hanya untuk Admin sesuai *BookPolicy*).

> <img width="1896" height="877" alt="Screenshot 2026-11-09 171024" src="https://github.com/user-attachments/assets/b3c28c4d-7b9c-40d3-9cb2-9337f058ee7f" />


## 11. View & Edit Book (Staff)

**View Book (Staff):** Menampilkan rincian informasi buku lengkap beserta sampulnya tanpa tombol tindakan hapus data (*Delete*).
> <img width="1881" height="891" alt="Screenshot 2026-11-09 171110" src="https://github.com/user-attachments/assets/d40f2904-d9e9-4430-87d7-64021fdf2e6c" />

**Edit Book (Staff):** Memungkinkan Staff memperbarui informasi rincian buku dan mengunggah berkas sampul.
> <img width="1895" height="890" alt="Screenshot 2026-11-09 171150" src="https://github.com/user-attachments/assets/6b135af9-f2d3-4892-81f9-8d3d02886967" />


## 12. Dashboard (Viewer)

Terautentikasi sebagai **Viewer User**. Viewer dapat melihat visualisasi statistik keseluruhan perpustakaan dan grafik status buku, namun seluruh fiturnya bersifat *read-only*.

> <img width="1896" height="897" alt="Screenshot 2026-11-09 171350" src="https://github.com/user-attachments/assets/c80f84c3-7549-4385-abea-121b2e00a825" />


## 13. Daftar Authors (Viewer)

Pada tabel *Authors*, tidak terdapat tombol *New author*. Opsi tindakan di kolom kanan hanya menyediakan tombol **View**. Ketika diklik, informasi nama *Author* muncul dalam modal *View author* tanpa opsi pengubahan data.

> <img width="1891" height="883" alt="Screenshot 2026-11-09 171419" src="https://github.com/user-attachments/assets/c70a9615-4ecf-47d0-8e19-a807552f5569" />
> <img width="1123" height="410" alt="image" src="https://github.com/user-attachments/assets/9b0db6a7-7d5e-4c50-b69e-3fafcdfb4985" />
 

## 14. Daftar Books (Viewer)

Tampilan daftar buku tidak dilengkapi dengan tombol pembuatan buku baru (*New book*). Kolom aksi di sisi kanan hanya menyediakan tombol **View**.

>  <img width="1887" height="875" alt="image" src="https://github.com/user-attachments/assets/ba7ed051-494c-4983-bda0-7962d739e2be" />

## 15. View Book Detail (Viewer)

Menampilkan seluruh atribut detail buku (Cover, Title, ISBN, Author, Publisher, Year, Status, Categories, dan Description) menggunakan komponen *Infolist* secara murni *read-only*, tanpa tersedianya tombol *Edit* maupun *Delete*.
> <img width="1886" height="843" alt="image" src="https://github.com/user-attachments/assets/5a7502ad-17f7-437e-a4eb-29d8a1c5b496" />
 
---

# BAGIAN 3 – Penjelasan Arsitektur

## 1. Penjelasan Arsitektur

### 1.1 Diagram ERD

Basis data aplikasi terdiri dari lima tabel: **authors**, **books**, **categories**, **users**, dan tabel penghubung **book_category**. Satu penulis dapat menulis banyak buku (1:N), satu buku dapat memiliki banyak kategori dan sebaliknya (M:N), sedangkan setiap pengguna memiliki satu dari tiga role, yaitu Admin, Staff, atau Viewer.

> <img width="3155" height="4125" alt="erd_chen_authbook_HD" src="https://github.com/user-attachments/assets/ad4ca9a5-47f9-4381-8f81-927f4251fc92" />

Keterangan notasi: persegi = entitas (tabel), oval = atribut (garis bawah = *primary key*), belah ketupat = relasi (atribut relasi yang bergaris bawah adalah *foreign key*). Garis ganda (||) berarti satu, dan kaki gagak berarti banyak. Kolom `author_id` pada Book adalah *foreign key* dari relasi *menulis*. Relasi *memiliki* diwujudkan oleh tabel pivot `book_category`. Semua akun berada pada satu entitas User. Panah dari User menunjukkan tiga role yang dibedakan oleh kolom `role`, yaitu Admin User, Staff User, dan Viewer User.

### 1.2 Penjelasan Relasi Antar Tabel

> <img width="4562" height="2716" alt="erd_tabel_authbook_warna_HD" src="https://github.com/user-attachments/assets/962a30fb-a945-4654-a427-98c78bdac5e0" />

**Relasi 1: authors (1) berelasi dengan books (N)**

Satu author dapat menulis banyak buku, tetapi setiap buku hanya memiliki satu author (*one-to-many*). *Foreign key* `author_id` diletakkan di sisi "banyak", yaitu tabel `books`, dan mengacu ke `authors.id`. Aturan hapus bersifat *cascade*, sehingga jika author dihapus maka seluruh bukunya ikut terhapus. Pada Eloquent, `Author::books()` memakai `hasMany` dan `Book::author()` memakai `belongsTo`.

**Relasi 2: books (M) berelasi dengan categories (N) melalui book_category**

Satu buku dapat memiliki banyak kategori dan satu kategori dapat berisi banyak buku (*many-to-many*). Relasi ini tidak dapat diwakili oleh satu *foreign key*, sehingga dipecah menjadi dua relasi *one-to-many* melalui tabel penghubung `book_category`: `books.id` (1) ke `book_category.book_id` (N), dan `categories.id` (1) ke `book_category.category_id` (N). Pada Eloquent, `Book::categories()` dan `Category::books()` sama-sama memakai `belongsToMany`. Pada form buku, relasi ini ditampilkan sebagai pilihan Categories yang dapat dipilih lebih dari satu.

**Relasi 3: users dan role**

Role disimpan sebagai kolom enum `role` pada tabel `users`, bukan sebagai tabel terpisah, sehingga tidak ada *foreign key*. Nilainya (`admin`, `staff`, `viewer`) dibaca oleh `BookPolicy` dan `AuthorPolicy` untuk menentukan hak akses. Admin memiliki akses penuh, Staff dapat menambah, mengubah, dan melihat data tanpa menghapus, sedangkan Viewer hanya dapat melihat data.

---

## 2. Kamus Data

Kamus data berikut merangkum seluruh tabel beserta nama field, tipe data, panjang, key (PK = primary key, FK = foreign key, UQ = unique), dan ketentuan nilai kosong (Null).
> <img width="5624" height="4700" alt="kamus_data_ulang" src="https://github.com/user-attachments/assets/d55c78da-e03a-4b3f-8383-241c00902c70" />


---

### 2.1 Alur Aplikasi (Request hingga Response)

**Contoh: `/admin/books`**

1. **Request:** Browser mengirim permintaan GET ke `/admin/books`.
2. **Routing dan middleware:** Route didaftarkan otomatis oleh `AdminPanelProvider`. Middleware autentikasi memeriksa sesi login; jika belum login, pengguna diarahkan ke `/admin/login`.
3. **Page (Livewire):** Route memanggil halaman `ListBooks`, yaitu komponen Livewire milik `BookResource`.
4. **Authorization:** Filament memanggil `BookPolicy` berdasarkan role pengguna. Pada hasil pengujian, tombol *New book* dan *Delete* hanya muncul untuk role yang diizinkan, dan jika izin ditolak pengguna menerima respons 403.
5. **Resource:** `BookResource::table()` menentukan kolom (Cover, ISBN, Title, Author, Categories, Publisher, Year, Status), pencarian, filter, dan pengurutan.
6. **Model dan database:** Eloquent menyusun query dari model `Book` beserta relasi `author` dan `categories`, mengirimnya ke database, lalu menerima hasilnya.
7. **Rendering:** Hasil dirender oleh Blade dan Livewire menjadi HTML dengan Tailwind CSS dan dikirim kembali sebagai response. Halaman dashboard dirender dengan cara yang sama, termasuk widget statistik dan grafik *Book Status Distribution*.
8. **Interaksi lanjutan:** Pencarian, filter, dan submit form dikirim sebagai pembaruan Livewire (AJAX) tanpa memuat ulang halaman penuh. Pada penyimpanan data, urutannya adalah validasi form, pengecekan policy, simpan ke database melalui model dengan `$fillable`, tampil notifikasi, lalu redirect ke daftar. File cover diunggah ke folder `book-covers` pada storage dan diakses melalui *symbolic link* `public/storage`.

> <img width="2280" height="3030" alt="flow-aplikasi" src="https://github.com/user-attachments/assets/4761025c-7f9c-4879-99a6-802af229f723" />

---

## 3. Perbandingan dengan Pendekatan Tradisional

Pada pendekatan tradisional, CRUD dibuat manual: route, controller, form request, dan view Blade ditulis satu per satu. Pada Filament, cukup satu perintah `make:filament-resource` dan satu file resource per entitas, lalu form dan tabel didefinisikan secara deklaratif.

| Aspek | Filament | CRUD manual (Laravel biasa) |
|-------|----------|-----------------------------|
| Waktu pengembangan | Cepat. Form, tabel, dan halaman dihasilkan dari satu perintah. | Lama. Route, controller, request, dan view dibuat satu per satu. |
| Jumlah kode | Sedikit dan deklaratif. | Banyak, terutama view Blade untuk index, create, edit, dan show. |
| Fitur bawaan | Pencarian, pengurutan, filter, pagination, bulk action, upload file, notifikasi, widget. | Harus dibuat sendiri atau memakai package tambahan. |
| Validasi | Terpasang pada komponen form (required, unique, maxLength). | Ditulis manual di FormRequest atau controller. |
| Authorization | Otomatis memakai Policy. | Dipanggil manual di controller atau middleware. |
| Tampilan | Modern, responsif, dan konsisten. | Dibuat dari nol; hasil bergantung pada kemampuan desain. |
| Kustomisasi UI | Terbatas pada komponen Filament. | Bebas sepenuhnya. |
| Kurva belajar | Perlu memahami konvensi Filament dan Livewire. | Cukup Laravel dasar, tetapi pengerjaan lebih panjang. |
| Pemahaman alur dasar | Banyak proses tersembunyi di balik komponen. | Setiap langkah terlihat jelas, baik untuk belajar. |
| Ketergantungan | Terikat versi Filament dan Livewire. | Minim, hanya Laravel. |

**Kelebihan dan kekurangan.** Filament unggul dalam kecepatan, konsistensi tampilan, dan banyaknya fitur siap pakai, tetapi fleksibilitas tampilan terbatas dan proses di balik komponen kurang terlihat. Pendekatan manual memberi kendali penuh dan membuat setiap langkah dapat dipahami, tetapi membutuhkan waktu dan kode yang jauh lebih banyak.

**Kapan memakai Filament.** Filament sesuai untuk panel admin, *back office*, dashboard internal, aplikasi yang banyak berisi CRUD, serta prototipe, seperti aplikasi manajemen buku ini.

**Kapan tidak.** Hindari untuk situs yang menghadap publik, tampilan yang sangat khusus, atau aplikasi mobile yang lebih tepat memakai API dan *framework* mobile.

---

## 4. Refleksi Pembelajaran

Melalui praktikum ini saya memahami alur pembuatan aplikasi Laravel dari *migration*, model, dan relasi Eloquent hingga resource Filament. Saya mempraktikkan relasi *one-to-many* (Author dan Book) serta *many-to-many* (Book dan Category) melalui tabel penghubung, *factory* dan *seeder* untuk data dummy, upload cover buku, pencarian dan filter, widget dashboard (Total Books, Total Authors, Books Available, Books Borrowed, dan grafik status buku), serta pembatasan akses berbasis role dengan Policy. Hasil pengujian dengan tiga role menunjukkan bahwa tampilan dan tombol aksi benar-benar berbeda: Admin dapat mengelola penuh, Staff tidak memiliki tombol Delete, dan Viewer hanya dapat melihat data. Filament membuktikan bahwa CRUD lengkap dapat dibuat dengan kode yang jauh lebih ringkas, sehingga waktu dapat dipakai untuk memikirkan struktur data dan aturan akses.

### Kesulitan dan Cara Mengatasi

| Kesulitan | Cara mengatasi |
|-----------|----------------|
| Memahami relasi many-to-many antara Book dan Category, terutama alasan perlunya tabel penghubung. | Membuat tabel `book_category`, mendefinisikan relasi `belongsToMany` di kedua model, lalu memakai pilihan Categories yang dapat dipilih lebih dari satu pada form buku. |
| Membuat tampilan dan hak akses yang berbeda untuk Admin, Staff, dan Viewer. | Menambah kolom `role` pada tabel `users`, membuat seeder untuk tiga user, dan menyesuaikan `BookPolicy` serta `AuthorPolicy`. Hasilnya diuji dengan login pada masing-masing role. |
| Gambar cover buku tidak tampil setelah diunggah. | Menjalankan `php artisan storage:link` dan memastikan file tersimpan pada folder `book-covers` di storage publik. |

### Rencana Pengembangan Selanjutnya

Aplikasi dapat dikembangkan dengan fitur peminjaman buku, yaitu tabel `loans` yang mencatat peminjam, tanggal pinjam, dan tanggal kembali, sehingga status *available* dan *borrowed* berubah otomatis. Pengembangan lain meliputi ekspor data ke Excel atau PDF, widget dashboard yang lebih lengkap, pencarian berdasarkan kategori, serta pengujian otomatis untuk Policy dan relasi model.
```
