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
      $user = User::where('id', Auth::user()->id)->with('metadata')->get();

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

      $day = DayRecord::where([
        ['dayRecordable_id', '=', Auth::user()->id],
        ['dayRecordable_type', '=', "App\\Entities\\User"]
      ])->orderBy('created_at', 'desc')->get();

      for ($i=0; $i < 7; $i++) {
        $datas['day_record']['day' . $i]['status'] =  $day[$i]['status'];
        $datas['day_record']['day' . $i]['plus'] =  $day[$i]['plus'];
        $datas['day_record']['day' . $i]['minus'] =  $day[$i]['minus'];
        $datas['day_record']['day' . $i]['amount'] =  $day[$i]['amount'];
        $datas['day_record']['day' . $i]['date'] =  $day[$i]['date'];
        $datas['day_record']['day' . $i]['date_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $day[$i]['created_at'])->format('d, M Y');
        $datas['day_record']['day' . $i]['nameday'] = Carbon::createFromFormat('Y-m-d H:i:s', $day[$i]['created_at'])->format('l');
        if ($day[$i]['status'] == 'plus') {
          $datas['day_record']['day' . $i]['value'] = '+' . $day[$i]['plus'];
        } else if ($day[$i]['status'] == 'minus') {
          $datas['day_record']['day' . $i]['value'] = '-' . $day[$i]['minus'];
        } else {
          $datas['day_record']['day' . $i]['value'] = 0;
        }
      }

      return response()->json($datas);
    }

    public function homeGroup()
    {
      // code...
    }
}
