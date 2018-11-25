<?php
namespace App\Transformers;

use App\Entities\User;
use App\Entities\DayRecord;
use League\Fractal\TransformerAbstract;

class DayRecordTransformer extends TransformerAbstract
{
  public function transform(DayRecord $dayrecord)
  {
    return [
      'id'           => $dayrecord->id,
      'status'       => $dayrecord->status,
      'amount'       => $dayrecord->amount,
      'minus'        => $dayrecord->minus,
      'plus'         => $dayrecord->plus,
      'date'         => $dayrecord->date,
      'created'      => $dayrecord->created_at->diffForHumans(),
    ];
  }
}
