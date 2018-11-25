<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Entities\Group;
use App\Entities\Transaction;
use App\Entities\DayRecord;
use Auth;
use Carbon\Carbon;
use App\Transformers\DayRecordTransformer;

class DayRecordController extends Controller
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

      $transactions = Transaction::where([
        ['date', $date->toDateString()],
        ['transactionable_id', $user->id],
        ['transactionable_type', "App\Entities\User"]
      ])->get();

      $plus = 0;
      $minus = 0;

      foreach ($transactions as $transaction) {
        if ($transaction->status == "plus") {
          $plus = $plus + $transaction->amount;
        } else {
          $minus = $minus + $transaction->amount;
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

      $dayrecord = new DayRecord([
        'status'       => $status,
        'amount'       => $amount,
        'minus'        => $minus,
        'plus'         => $plus,
        'date'         => $date->toDateString(),
      ]);
      $user->dayRecords()->save($dayrecord);

    }

    // Group

    $groups = Group::where('region', $region)->get();

    foreach ($groups as $group) {

      $transactions = Transaction::where([
        ['date', $date->toDateString()],
        ['transactionable_id', $group->id],
        ['transactionable_type', "App\Entities\Group"]
      ])->get();

      $plus = 0;
      $minus = 0;

      foreach ($transactions as $transaction) {
        if ($transaction->status == "plus") {
          $plus = $plus + $transaction->amount;
        } else {
          $minus = $minus + $transaction->amount;
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

      $dayrecord = new DayRecord([
        'status'       => $status,
        'amount'       => $amount,
        'minus'        => $minus,
        'plus'         => $plus,
        'date'         => $date->toDateString(),
      ]);
      $group->dayRecords()->save($dayrecord);

    }

    return "Day Record " . $region . " : " . $date->toDateString() . ". DONE!";
  }

  public function show($type, Group $group, DayRecord $dayrecord)
  {
    if ($type == "user") {
      $class = DayRecord::where([
        ['dayRecordable_id', Auth::user()->id],
        ['dayRecordable_type', "App\Entities\User"]
      ])->get();
    } else if ($type == "group") {
      $this->authorize('authorization', $group);
      $class = DayRecord::where([
        ['dayRecordable_id', $group->id],
        ['dayRecordable_type', "App\Entities\Group"]
      ])->get();
    }

    $response = fractal()
                  ->collection($class)
                  ->transformWith(new DayRecordTransformer)
                  ->toArray();

    return response()->json($response);
  }

}
