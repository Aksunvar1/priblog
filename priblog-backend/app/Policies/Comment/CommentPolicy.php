<?php

namespace App\Policies\Comment;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class CommentPolicy
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

    public function view(?User $user, ?Comment $comment): Response
    {
        return $this->allow();
    }

    public function update(?User $user, Comment $comment): Response
    {
        if ($comment->user->id === $user->id) {
            return $this->allow();
        }

        return $this->deny('not allowed');
    }

    public function delete(?User $user, Comment $comment): Response
    {
        return $this->update($user, $comment);
    }
}
