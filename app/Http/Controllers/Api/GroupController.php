<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Group;
use App\Entities\User;
use App\Transformers\GroupTransformer;
use App\Transformers\UserTransformer;
use Auth;
use File;

class GroupController extends Controller
{

    public function add(Request $request)
    {
      $this->validate($request, [
        'name'         => 'required',
        'description'  => 'required',
        'balance'      => 'required|integer',
        'region'       => 'required|in:west,middle,east',
      ]);

      $group = Group::create([
        'name'        => $request['name'],
        'description' => $request['description'],
        'balance'     => $request['balance'],
        'region'      => $request['region'],
        'created_by'  => Auth::user()->id,
      ]);

      $user = User::find(Auth::user()->id);
      $group->users()->attach($user);

      $response = fractal()
                    ->item($group)
                    ->transformWith(new GroupTransformer)
                    ->toArray();

      return response()->json($response, 201);
    }

    public function show(Group $group)
    {
      $this->authorize('show', $group);

      $response = fractal()
                    ->item($group)
                    ->transformWith(new GroupTransformer)
                    ->toArray();

      return response()->json($response, 201);
    }

    public function showAll()
    {
      $user = User::find(Auth::user()->id);

      $response = fractal()
                    ->collection($user->groups)
                    ->transformWith(new GroupTransformer)
                    ->toArray();

      return response()->json($response, 201);
    }

    public function update(Request $request, Group $group)
    {
      $this->authorize('update', $group);

      $this->validate($request, [
        'name'         => 'required',
        'description'  => 'required',
        'balance'      => 'required|integer',
        'region'       => 'required|in:west,middle,east',
      ]);

      $group->name = $request->get('name', $group->name);
      $group->description = $request->get('description', $group->description);
      $group->balance = $request->get('balance', $group->balance);
      $group->region = $request->get('region', $group->region);
      $group->save();

      $response = fractal()
                    ->item($group)
                    ->transformWith(new GroupTransformer)
                    ->toArray();

      return response()->json($response, 201);
    }

    public function updatePhoto(Request $request, Group $group)
    {
      $this->authorize('update', $group);

      $this->validate($request, [
        'photo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:ratio=1',
      ]);

      if ($group->photo != null) {
        File::delete(public_path() . '/images/group/' . $group->photo);
      }

      $image = $request['photo'];
      $filename = time().'.'. $image->getClientOriginalExtension();
      $image->move(public_path('images/group'), $filename);

      $group->photo = $filename;
      $group->save();

      return response()->json([
        "message" => "Successfully change photo group."
      ]);
    }

    public function delete(Group $group)
    {
      $this->authorize('delete', $group);

      $group->delete();

      $group->users()->detach();

      return response()->json([
        "mesaage" => "Group deleted",
      ]);
    }

    public function showMember(Group $group)
    {
      $group = Group::find($group->id);
      $users = $group->users;

      $response = fractal()
                    ->collection($users)
                    ->transformWith(new UserTransformer)
                    ->addMeta([
                      'photo' => $users->metadata->photo
                    ])
                    ->toArray();

      return response()->json($response);
    }

    public function addMember(Request $request, Group $group)
    {
      if ($group->created_by != Auth::user()->id) {
        abort(403, 'Denied Action.');
      }

      $this->validate($request, [
        'email' => 'required|email'
      ]);

      $user = User::where('email', $request['email'])->get();
      $user = User::find($user[0]->id);

      if ($user->groups->contains($group->id)) {
        return response()->json([
          "message" => "Member Exists."
        ]);
      } else {
          $group->users()->attach($user);
      }

      return response()->json([
        "message" => "Member Added."
      ]);
    }

    public function removeMember(Request $request, Group $group)
    {
      if ($group->created_by != Auth::user()->id) {
        abort(403, 'Denied Action.');
      }

      $this->validate($request, [
        'email' => 'required|email'
      ]);

      $user = User::where('email', $request['email'])->get();
      $group->users()->detach($user);

      return response()->json([
        "message" => "Member Removed."
      ]);
    }

    public function leave(Group $group)
    {
      $user = User::find(Auth::user()->id);
      $group->users()->detach($user);

      return response()->json([
        "message" => "Success Leave Group."
      ]);
    }
}
