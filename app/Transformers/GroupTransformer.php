<?php
namespace App\Transformers;

use App\Entities\User;
use App\Entities\Group;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

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
      'date_human' => Carbon::createFromFormat('Y-m-d H:i:s', $group->created_at)->format('d, M Y'),
      'created'       => $group->created_at->diffForHumans(),
    ];
  }
}
