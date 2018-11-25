<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entities\Role;
use App\Entities\UserMetadata;
use App\Entities\Transaction;
use App\Entities\DayRecord;
use App\Entities\MonthRecord;
use App\Entities\Activity;
use App\Entities\Group;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password' , 'balance' , 'api_token', 'email_token', 'email_verified_at', 'is_banned'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function roles()
    {
      return $this->belongsToMany(Role::class);
    }

    public function authorizeRoles($roles)
    {
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');
      }
      return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }

    public function checkAuth($roles)
    {
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) || false;
      }
      return $this->hasRole($roles) || false;
    }

    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role)
    {
      return null !== $this->roles()->where('name', $role)->first();
    }

    public function metadata()
    {
      return $this->hasOne(UserMetadata::class);
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

    public function activities()
    {
      return $this->hasMany(Activity::class);
    }

    public function groups()
    {
      return $this->belongsToMany(Group::class);
    }

    public function haveTransaction(Transaction $transaction)
    {
      return auth()->id() == $transaction->transactionable->id;
    }

    public function haveGroup(Group $group)
    {
      $user = User::find(auth()->id());
      return $user->groups->contains($group->id);
    }
}
