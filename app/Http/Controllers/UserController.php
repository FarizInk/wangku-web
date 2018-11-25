<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\UserMetadata;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth', 'user']);
    }

    public function profile()
    {
      $user = Auth::user();
      $metadata = UserMetadata::where('user_id', $user->id)->get();

      foreach ($metadata as $value) {
        $metadata = $value;
      }

      return view('profile', [
        'metadata' => $metadata
      ]);
    }
}
