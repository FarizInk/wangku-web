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
      $user = User::find(Auth::user()->id)->with('metadata')->get();

      foreach ($user as $data) {
        $datas = [
          "name" => $data->name,
          "balance" => $data->balance,
          "photo" => $data->metadata->photo
        ];
      }

      $transactions = Transaction::all()->count();

      $datas["transactions"] = $transactions;

      return response()->json($datas);
    }

    public function homeGroup()
    {
      // code...
    }
}
