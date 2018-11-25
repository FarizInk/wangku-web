<?php
namespace App\Transformers;

use App\Entities\User;
use App\Entities\MonthRecord;
use League\Fractal\TransformerAbstract;

class MonthRecordTransformer extends TransformerAbstract
{
  public function transform(MonthRecord $monthrecord)
  {
    return [
      'id'           => $monthrecord->id,
      'status'       => $monthrecord->status,
      'amount'       => $monthrecord->amount,
      'description'  => $monthrecord->description,
      'date'         => $monthrecord->date,
      'time'         => $monthrecord->time,
      'created'      => $monthrecord->created_at->diffForHumans(),
    ];
  }
}
