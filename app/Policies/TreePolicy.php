<?php
namespace App\Policies;
use App\Models\Tree;
use App\Models\User;

class TreePolicy
{
    public function view(User $user, Tree $tree): bool
    {
        return $user->id === (int) $tree->owner_id;
    }
    public function care(User $user, Tree $tree): bool
    {
        return $user->id === (int) $tree->owner_id;
    }
}
