<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    // By User

    public function showByUser(User $user, Transaction $transaction)
    {
     return $user->haveTransaction($transaction);
    }

    public function updateByUser(User $user, Transaction $transaction)
    {
      return $user->haveTransaction($transaction);
    }

    public function deleteByUser(User $user, Transaction $transaction)
    {
      return $user->haveTransaction($transaction);
    }
}
