<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\User;

class Transaction extends Model
{
    protected $fillable = [
      'user_id', 'status', 'amount', 'description', 'date', 'time', 'created_by', 'transactionable_id', 'transactionable_type'
    ];

    public function transactionable()
    {
      return $this->morphTo();
    }

    public function setAmountAttribute($value)
    {
        $value = str_replace('-', '', $value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '', $value);
        $this->attributes['amount'] = $value;
    }
}
