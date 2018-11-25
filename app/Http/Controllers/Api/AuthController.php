<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Hash;
use App\Entities\Role;
use Auth;
use Illuminate\Auth\Events\Registered;
use App\Jobs\SendVerificationEmail;
use App\Entities\UserMetadata;

class AuthController extends Controller
{
    public function create(array $request)
    {
      $user = User::create([
        'name'        => $request['name'],
        'email'       => $request['email'],
        'password'    => Hash::make($request['password']),
        'email_token' => base64_encode($request['email']),
      ]);

      $user
         ->roles()
         ->attach(Role::where('name', 'user')->first());

      return $user;
    }

    public function register(Request $request, UserMetadata $metadata)
    {
      $this->validate($request, [
        'name'     => 'required',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:8'
      ]);
      event(new Registered($user = $this->create($request->all())));
      dispatch(new SendVerificationEmail($user));

      $metadata->create([
        'user_id'     => $user->id,
        'gender'      => null,
        'photo'       => null,
        'region'      => 'west',
        'time_record' => '23:59:59'
      ]);

      $response = fractal()
                    ->item($user)
                    ->transformWith(new UserTransformer)
                    ->toArray();

      return response()->json($response, 201);
    }

    public function login(Request $request, User $user)
    {
      $this->validate($request, [
        'email'     =>  'required|email',
        'password'  =>  'required'
      ]);

      $email = strtolower($request['email']);

      if (!Auth::attempt(['email' => $email, 'password' => $request->password])) {
        return response()->json(['error' => 'Wrong Credential.'], 401);
      }

      $user = $user->find(Auth::user()->id);
      $user->api_token = bcrypt($user->email);
      $user->save();

      $response = fractal()
              ->item($user)
              ->transformWith(new UserTransformer)
              ->addMeta([
                'token' => $user->api_token,
              ])
              ->toArray();

      return response()->json($response, 201);
    }
}
