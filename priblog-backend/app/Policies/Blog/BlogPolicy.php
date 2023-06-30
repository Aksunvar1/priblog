<?php

namespace App\Policies\Blog;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class BlogPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): Response
    {
        return $this->allow();
    }

    public function create(?User $user): Response
    {
        return $this->allow();
    }

    public function view(?User $user, ?Blog $blog): Response
    {
        return $this->allow();
    }

    public function update(?User $user, Blog $blog): Response
    {
        if ($blog->user->id === $user->id) {
            return $this->allow();
        }

        return $this->deny('not allowed update others blogs');
    }

    public function delete(?User $user, Blog $blog): Response
    {
        return $this->update($user, $blog);
    }
}
