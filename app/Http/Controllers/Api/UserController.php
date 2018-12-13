<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Transformers\UserTransformer;
use Auth;
use Hash;
use Illuminate\Auth\Events\Registered;
use App\Jobs\SendVerificationEmail;
use File;
use Carbon\Carbon;

class UserController extends Controller
{
    public function users(User $user)
    {
      $users = $user->all();

      return fractal()
          ->collection($users)
          ->transformWith(new UserTransformer)
          ->toArray();
    }

    public function profile(User $user)
    {
      // $user = $user->find(Auth::user()->id);
      $user = User::with('metadata')->find(Auth::user()->id);

      $response = fractal()
                    ->item($user)
                    ->transformWith(new UserTransformer)
                    ->addMeta([
                      'gender' => $user->metadata->gender,
                      'photo' => $user->metadata->photo,
                      'region' => $user->metadata->region,
                      'time_record' => $user->metadata->time_record,
                    ])
                    ->toArray();

      return response()->json($response, 201);
    }

    public function update(Request $request, User $user)
    {

      $this->validate($request, [
        'name'        => 'required',
        'balance'     => 'required|integer',
        'gender'      => 'required|in:male,female',
        'region'      => 'required|in:west,middle,east',
        // 'time_record' => 'required'
      ]);

      $user = $user->with('metadata')->find(Auth::user()->id);

      $user->name = $request->get('name', $user->name);
      $user->balance = $request->get('balance', $user->balance);
      $user->metadata->gender = $request->get('gender', $user->metadata->gender);
      $user->metadata->region = $request->get('region', $user->metadata->region);
      $user->metadata->time_record = $request->get('time_record', $user->metadata->time_record);
      $user->save();
      $user->metadata->save();

      $response = fractal()
                  ->item($user)
                  ->transformWith(new UserTransformer)
                  ->addMeta([
                    'gender' => $user->metadata->gender,
                    'photo' => $user->metadata->photo,
                    'region' => $user->metadata->region,
                    'time_record' => $user->metadata->time_record,
                  ])
                  ->toArray();

      return response()->json($response, 201);
    }

    public function updateEmail(Request $request,User $user)
    {
      $this->validate($request, [
          'email' => 'required|email|unique:users',
      ]);
      $user = $user->find(Auth::user()->id);

      $user->email = $request['email'];
      $user->email_verified_at = null;
      $user->email_token = base64_encode($request['email']);
      $user->save();


      dispatch(new SendVerificationEmail($user));

      return response()->json([
        "message" => "Successfully change email, please check your email to confirm your identity."
      ]);
    }

    public function updatePassword(Request $request,User $user)
    {
      $this->validate($request, [
          'password' => 'required|min:8',
      ]);
      $user = $user->find(Auth::user()->id);

      $user->password = Hash::make($request['password']);
      $user->save();

      return response()->json([
        "message" => "Successfully change password."
      ]);
    }

    public function updatePhoto(Request $request,User $user)
    {
      // dd($request);
      $this->validate($request, [
        'photo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:ratio=1',
      ]);
      $user = User::with('metadata')->find(Auth::user()->id);

      if ($user->metadata->photo != null) {
        File::delete(public_path() . '/images/profile/' . $user->metadata->photo);
      }

      $image = $request['photo'];
      $filename = time().'.'. $image->getClientOriginalExtension();
      $image->move(public_path('images/profile'), $filename);

      $user->metadata->photo = $filename;
      $user->metadata->save();

      return response()->json([
        "message" => "Successfully change photo."
      ]);

    }

    public function checkApi()
    {
      return "true";
    }

    public function datenow()
    {
      $user = User::find(Auth::user()->id);
      if ($user->region == "west") {
        $date = Carbon::now()->setTimezone('Asia/Jakarta');
      } else if ($user->region == "middle") {
        $date = Carbon::now()->setTimezone('Asia/Singapore');
      } else if ($user->region == "east") {
        $date = Carbon::now()->setTimezone('Asia/Tokyo');
      } else {
        $date = Carbon::now()->setTimezone('Asia/Jakarta');
      }

      return response()->json([
        "datenow" => $date->toDateString(),
      ]);
    }

    public function sendemail()
    {
      $user = User::find(Auth::user()->id);

      dispatch(new SendVerificationEmail($user));

      return response()->json([
        "message" => "Successfully send verification, please check your email to confirm your identity."
      ]);
    }
}
