<?php
namespace App\Transformers;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
  public function transform(User $user)
  {
    return [
      'id'                 => $user->id,
      'name'               => $user->name,
      'email'              => $user->email,
      'balance'            => $user->balance,
      'verified'           => $user->email_verified_at,
      'registered'         => $user->created_at->diffForHumans(),
    ];
  }
}
