<?php
namespace App\Transformers;

use App\Entities\User;
use App\Entities\DayRecord;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

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
      'date_human'   => Carbon::createFromFormat('Y-m-d H:i:s', $dayrecord->created_at)->format('l, d M Y'),
      'created'      => $dayrecord->created_at->diffForHumans(),
    ];
  }
}
