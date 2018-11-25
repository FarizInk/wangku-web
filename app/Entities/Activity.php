<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\User;

class Activity extends Model
{
    protected $fillable = [
      'user_id', 'description', 'date', 'time'
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
}
