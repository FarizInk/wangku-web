<?php
namespace App\Transformers;

use App\Entities\User;
use App\Entities\Transaction;
use League\Fractal\TransformerAbstract;

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
      'created'      => $transaction->created_at->diffForHumans(),
    ];
  }
}
