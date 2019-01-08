<?php
namespace App\Transformers;

use App\Entities\User;
use App\Entities\MonthRecord;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

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
      'date_human'   => Carbon::createFromFormat('Y-m-d H:i:s', $monthrecord->created_at)->format('d, M Y'),
      'created'      => $monthrecord->created_at->diffForHumans(),
    ];
  }
}
