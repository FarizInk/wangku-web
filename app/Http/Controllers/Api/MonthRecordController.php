<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Entities\Group;
use App\Entities\DayRecord;
use App\Entities\MonthRecord;
use Carbon\Carbon;
use App\Transformers\MonthRecordTransformer;
use Auth;

class MonthRecordController extends Controller
{
  public function record($region, $key)
  {
    if ($key != env("GOOGLE_SCRIPT_KEY")) {
      abort(401, 'Wrong Key!');
    }
    $users = User::join('user_metadatas', 'users.id', '=', 'user_metadatas.user_id')->where('region', $region)->get();

    if ($region == "west") {
      $date = Carbon::now()->setTimezone('Asia/Jakarta');
    } else if ($region == "middle") {
      $date = Carbon::now()->setTimezone('Asia/Singapore');
    } else if ($region == "east") {
      $date = Carbon::now()->setTimezone('Asia/Tokyo');
    }

    foreach ($users as $user) {

      $dayrecords = DayRecord::where([
        ['date', 'like', $date->format('Y-m') . '%'],
        ['dayRecordable_id', $user->id],
        ['dayRecordable_type', "App\Entities\User"]
      ])->get();

      $plus = 0;
      $minus = 0;

      foreach ($dayrecords as $dayrecord) {
        if ($dayrecord->status == "plus") {
          $plus = $plus + $dayrecord->amount;
        } else {
          $minus = $minus + $dayrecord->amount;
        }
      }

      if ($plus > $minus) {
        $status = "plus";
        $amount = $plus - $minus;
      } else if ($minus > $plus) {
        $status = "minus";
        $amount = $minus - $plus;
      } else {
        $status = "-";
        $amount = "0";
      }

      $monthrecord = new MonthRecord([
        'status'       => $status,
        'amount'       => $amount,
        'minus'        => $minus,
        'plus'         => $plus,
        'date'         => $date->toDateString(),
      ]);
      $user->monthRecords()->save($monthrecord);

    }

    return "Month Record " . $region . " : " . $date->toDateString() . ". DONE!";
  }

  public function show($type, Group $group, MonthRecord $monthrecord)
  {
    if ($type == "user") {
      $class = MonthRecord::where([
        ['monthRecordable_id', Auth::user()->id],
        ['monthRecordable_type', "App\Entities\User"]
      ])->orderBy('created_at', 'desc')->paginate(10);
    } else if ($type == "group") {
      $this->authorize('authorization', $group);
      $class = MonthRecord::where([
        ['monthRecordable_id', $group->id],
        ['monthRecordable_type', "App\Entities\Group"]
      ])->orderBy('created_at', 'desc')->paginate(10);
    }

    $response = fractal()
                  ->collection($class)
                  ->transformWith(new MonthRecordTransformer)
                  ->toArray();

    return response()->json($response);
  }
}
