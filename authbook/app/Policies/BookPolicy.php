<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    // Semua role (Admin, Staff, Viewer) bisa melihat daftar buku
    public function viewAny(User $user): bool
    {
        return true; 
    }

    // Semua role bisa melihat detail buku
    public function view(User $user, Book $book): bool
    {
        return true; 
    }

    // Admin & Staff bisa menambah buku baru
    public function create(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'staff';
    }

    // Admin & Staff bisa mengedit buku
    public function update(User $user, Book $book): bool
    {
        return $user->role === 'admin' || $user->role === 'staff';
    }

    // HANYA Admin yang bisa menghapus buku
    public function delete(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }

    // HANYA Admin yang bisa menghapus banyak buku sekaligus (bulk delete)
    public function deleteAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    // HANYA Admin yang bisa restore & force delete
    public function restore(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }
}