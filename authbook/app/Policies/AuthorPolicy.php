<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\User;

class AuthorPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Semua bisa lihat
    }

    public function view(User $user, Author $author): bool
    {
        return true; // Semua bisa lihat detail
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'staff'; // Admin & Staff bisa tambah
    }

    public function update(User $user, Author $author): bool
    {
        return $user->role === 'admin' || $user->role === 'staff'; // Admin & Staff bisa edit
    }

    public function delete(User $user, Author $author): bool
    {
        return $user->role === 'admin'; // HANYA Admin yang bisa hapus
    }

    public function deleteAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Author $author): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Author $author): bool
    {
        return $user->role === 'admin';
    }
}