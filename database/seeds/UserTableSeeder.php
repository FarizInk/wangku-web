<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Entities\Role;
use App\Entities\UserMetadata;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role_admin = Role::where('name', 'admin')->first();
      $role_user  = Role::where('name', 'user')->first();

      $admin = new User();
      $admin->name = 'admin';
      $admin->email = 'admin@example.com';
      $admin->password = Hash::make('admin');
      $admin->save();
      $admin->roles()->attach($role_admin);

      $metadata = new UserMetadata();
      $metadata->user_id = $admin->id;
      $metadata->gender = 'male';
      $metadata->photo = null;
      $metadata->region = 'west';
      $metadata->time_record = '23:59:59';
      $metadata->save();

      for ($i=1; $i <= 10; $i++) {
        $user = new User();
        $user->name = 'user'. $i;
        $user->email = 'user' . $i . '@example.com';
        $user->password = Hash::make('user');
        $user->save();
        $user->roles()->attach($role_user);

        $metadata = new UserMetadata();
        $metadata->user_id = $user->id;
        $metadata->gender = 'male';
        $metadata->photo = null;
        $metadata->region = 'west';
        $metadata->time_record = '23:59:59';
        $metadata->save();
      }
    }
}
