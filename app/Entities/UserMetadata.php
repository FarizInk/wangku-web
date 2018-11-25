<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\User;

class UserMetadata extends Model
{
    protected $fillable = [
      'user_id', 'gender', 'photo', 'region', 'time_record'
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
}
