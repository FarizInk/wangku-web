<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\User;

class DayRecord extends Model
{
    protected $fillable = [
      'user_id', 'status', 'amount', 'minus', 'plus', 'date'
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function dayRecordable()
    {
      return $this->morphTo();
    }
}
