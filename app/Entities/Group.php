<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
      'name', 'description', 'balance', 'region', 'created_by', 'photo'
    ];

    public function users()
    {
      return $this->belongsToMany(User::class);
    }

    public function transactions()
    {
      return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function dayRecords()
    {
      return $this->morphMany(DayRecord::class, 'dayRecordable');
    }

    public function monthRecords()
    {
      return $this->morphMany(MonthRecord::class, 'monthRecordable');
    }
}
