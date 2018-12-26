<?php
namespace App\Transformers;

use App\Entities\User;
use App\Entities\Transaction;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class TransactionTransformer extends TransformerAbstract
{
  public function transform(Transaction $transaction)
  {
    return [
      'id'           => $transaction->id,
      'status'       => $transaction->status,
      'amount'       => $transaction->amount,
      'description'  => $transaction->description,
      'date'         => $transaction->date,
      'time'         => $transaction->time,
      'created_by'   => $transaction->created_by,
      'date_human' => Carbon::createFromFormat('Y-m-d H:i:s', $transaction->created_at)->format('d, M Y'),
      'created'      => $transaction->created_at->diffForHumans(),
    ];
  }
}
