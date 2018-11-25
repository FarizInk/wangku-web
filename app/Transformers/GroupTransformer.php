<?php
namespace App\Transformers;

use App\Entities\User;
use App\Entities\Group;
use League\Fractal\TransformerAbstract;

class GroupTransformer extends TransformerAbstract
{
  public function transform(Group $group)
  {
    return [
      'id'            => $group->id,
      'name'          => $group->name,
      'description'   => $group->description,
      'balance'       => $group->balance,
      'region'        => $group->region,
      'owner'         => $group->created_by,
      'photo'         => $group->photo,
      'created'       => $group->created_at->diffForHumans(),
    ];
  }
}
