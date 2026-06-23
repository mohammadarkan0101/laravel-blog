<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Blog;
use Illuminate\Auth\Access\Response;

class BlogPolicy
{
    public function update(User $user, Blog $blog): Response
    {
        return $user->id === $blog->user_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengubah blog ini.');
    }

    public function delete(User $user, Blog $blog): Response
    {
        return $user->id === $blog->user_id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus blog ini.');
    }
}