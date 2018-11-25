<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Group $group)
    {
     return $user->haveGroup($group);
    }

    public function update(User $user, Group $group)
    {
     return $user->haveGroup($group);
    }

    public function delete(User $user, Group $group)
    {
     return $user->haveGroup($group);
    }

    public function authorization(User $user, Group $group)
    {
      return $user->haveGroup($group);
    }
}
