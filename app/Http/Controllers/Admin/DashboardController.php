<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Entities\Transaction;
use App\Entities\Group;
use App\Entities\Activity;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
  }

  public function index()
  {
    $dateNow = Carbon::now()->setTimezone('Asia/Jakarta')->toDateString();
    $data = [
      'users' => count(User::withTrashed()->get()),
      'transactions' => count(Transaction::all()),
      'groups' => count(Group::all()),
      'activities' => count(Activity::all()),
      'todayTransactions' => count(Transaction::where('date', $dateNow)->get()),
      'todayActivities' => count(Activity::where('date', $dateNow)->get()),
    ];

    return view('admin.index', ['data' => $data]);
  }
}
