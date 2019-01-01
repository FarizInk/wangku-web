<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Entities\Transaction;
use App\Entities\Group;
use App\Entities\DayRecord;
use App\Entities\MonthRecord;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    public function home()
    {
      $date = Carbon::now()->setTimezone('Asia/Jakarta');
      $user = User::find(Auth::user()->id)->with('metadata')->get();

      foreach ($user as $data) {
        $datas = [
          "name" => $data->name,
          "balance" => $data->balance,
          "photo" => $data->metadata->photo
        ];
      }

      $transactions = Transaction::where([
        ['transactionable_id', '=', Auth::user()->id],
        ['transactionable_type', '=', "App\\Entities\\User"]
      ]);
      $datas["transactions"] = $transactions->count();

      $today = Transaction::where([
        ['transactionable_id', '=', Auth::user()->id],
        ['transactionable_type', '=', "App\\Entities\\User"],
        ['date', '=', $date->toDateString()]
      ]);
      $datas['today'] = $today->count();

      $todayData = $today->get();
      $dayIncome = 0;
      $daySpending = 0;
      foreach ($todayData as $value) {
        if ($value->status == "plus") {
          $dayIncome = $dayIncome + $value->amount;
        } else {
          $daySpending = $daySpending + $value->amount;
        }
      }
      $datas["day_income"] = $dayIncome;
      $datas["day_spending"] = $daySpending;

      return response()->json($datas);
    }

    public function homeGroup()
    {
      // code...
    }
}
