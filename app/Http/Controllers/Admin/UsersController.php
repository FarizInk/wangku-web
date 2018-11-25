<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Entities\UserMetadata;
use App\Entities\Role;
use Carbon\Carbon;

class UsersController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
  }

  public function index()
  {
    $admin = Role::where('name', 'admin')->first();
    $admins = Role::find($admin['id'])->users()->get();

    $user = Role::where('name', 'user')->first();
    $users = Role::find($user['id'])->users()->orderBy('id', 'desc')->paginate(9);

    return view('admin.users', [
      'admins' => $admins,
      'users' => $users,
    ]);
  }

  public function softDelete(Request $request)
  {
    $user = User::find($request->id);
    $user->delete();

    return redirect()->back()->with('success', 'User Banned!');
  }

  public function banned()
  {
    $users = User::with('transactions')->onlyTrashed()->paginate(10);

    return view('admin.users-banned', [
      'users' => $users,
    ]);
  }

  public function unban(Request $request)
  {
    $user = User::withTrashed()->find($request->id)->restore(0);

    return redirect()->back()->with('success', 'User Unban!');
  }

  public function delete(Request $request)
  {
    $user = User::withTrashed()->find($request->id);
    $user->metadata->delete();
    $user->forceDelete();

    return redirect()->back()->with('success', 'User Deleted!');
  }

  public function profileCard($id)
  {
    $user = User::where('id', $id)->get();

    foreach ($user as $value) {
      $user = $value;
    }

    $metadata = UserMetadata::where('user_id', $id)->get();

    foreach ($metadata as $value) {
      $metadata = $value;
    }

    $transactions = count($user->transactions);

    return view('admin.elements.profile-card', [
      'user' => $user,
      'metadata' => $metadata,
      'transactions' => $transactions
    ]);
  }

  public function edit($id)
  {
    $user = User::where('id', $id)->get();

    foreach ($user as $value) {
      $user = $value;
    }

    $metadata = UserMetadata::where('user_id', $id)->get();

    foreach ($metadata as $value) {
      $metadata = $value;
    }

    $transactions = count($user->transactions);

    return view('admin.edit-user', [
      'user' => $user,
      'metadata' => $metadata,
      'transactions' => $transactions
    ]);
  }

  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'name'        => 'required',
      'balance'     => 'required|integer',
      'gender'      => 'required|in:male,female',
      'region'      => 'required|in:west,middle,east'
    ]);
    $user = User::with('metadata')->find($id);

    $user->name = $request->name;
    $user->balance = $request->balance;
    $user->metadata->gender = $request->gender;
    $user->metadata->region = $request->region;
    $user->save();
    $user->metadata->save();

    return redirect()->back()->with('success', 'User Data Changed!');
  }
}
