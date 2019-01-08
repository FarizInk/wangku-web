<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Entities\Group;
use App\Entities\Transaction;
use App\Entities\DayRecord;
use App\Entities\MonthRecord;
use App\Transformers\TransactionTransformer;
use App\Transformers\AllTransactionTransformer;
use Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function add(Request $request, $type, Group $group)
    {
      $this->validate($request, [
        'status'      => 'required|in:plus,minus',
        'amount'      => 'required|integer',
        'description' => 'nullable',
      ]);

      if ($type == "user") {
        $class = User::with('metadata')->find(Auth::user()->id);
        $dateClass = $class->metadata->region;

        if ($request->status == "minus") {
          if ($class->balance <= $request->amount) {
            return response()->json([
              "errors" => [
                "amount" => ["Your balance is insufficient."]
              ]
            ], 422);
          }
        }
      } else if ($type == "group") {
        $this->authorize('authorization', $group);
        $class = $group;
        $dateClass = $group->region;

        if ($request->status == "minus") {
          if ($class->balance <= $request->amount) {
            return response()->json([
              "errors" => [
                "amount" => ["The Group balance is insufficient."]
              ]
            ], 422);
          }
        }
      }

      if ($dateClass == "west") {
        $date = Carbon::now()->setTimezone('Asia/Jakarta');
      } else if ($dateClass == "middle") {
        $date = Carbon::now()->setTimezone('Asia/Singapore');
      } else if ($dateClass == "east") {
        $date = Carbon::now()->setTimezone('Asia/Tokyo');
      } else {
        $date = Carbon::now()->setTimezone('Asia/Jakarta');
      }

      $transaction = new Transaction([
        'status'       => $request->status,
        'amount'       => $request->amount,
        'description'  => $request->description,
        'date'         => $date->toDateString(),
        'time'         => $date->toTimeString(),
        'created_by'   => Auth::user()->id
      ]);

      $class->transactions()->save($transaction);

      if ($request->status == "minus") {
        $class->balance = $class->balance - $request->amount;
      } else {
        $class->balance = $class->balance + $request->amount;
      }

      $class->save();

      $response = fractal()
              ->item($transaction)
              ->transformWith(new TransactionTransformer)
              ->toArray();

      return response()->json($response, 201);
    }

    public function showAll($type, Group $group)
    {
      if ($type == "user") {
        $class = Transaction::where([
          ['transactionable_id', '=', Auth::user()->id],
          ['transactionable_type', '=', "App\\Entities\\User"]
        ])->orderBy('created_at', 'desc')->paginate(10);

        $response = fractal()
                      ->collection($class)
                      ->transformWith(new TransactionTransformer)
                      ->toArray();

        return response()->json($response);
      } else if ($type == "group") {
        $date = Carbon::now()->setTimezone('Asia/Jakarta');
        $this->authorize('authorization', $group);
        $class = Transaction::where([
          ['date', '!=', $date->toDateString()],
          ['transactionable_id', '=', $group->id],
          ['transactionable_type', '=', "App\\Entities\\Group"]
        ])->orderBy('created_at', 'desc')->paginate(10);

        $response = fractal()
                      ->collection($class)
                      ->transformWith(new AllTransactionTransformer)
                      ->toArray();

        return response()->json($response);
      }
    }

    public function show($type, Group $group, Transaction $transaction)
    {
      if ($type == "user") {
        $this->authorize('showByUser', $transaction);
        $class = $transaction;
      } else if ($type == "group") {
        $user = User::find(Auth::user()->id);
        $exists = $user->groups->contains($transaction->transactionable_id);
        if ($transaction->transactionable_type != "App\Entities\Group") {
          abort(403, 'Unauthorized action.');
        } else if (!$exists) {
          abort(403, 'Unauthorized action.');
        }
        $class = $transaction;
      }

      $response = fractal()
                    ->item($class)
                    ->transformWith(new AllTransactionTransformer)
                    ->toArray();

      return response()->json($response);
    }

    public function update(Request $request, $type, Group $group, Transaction $transaction)
    {
      if (Auth::user()->id == $transaction->created_by) {
        if ($type == "user") {
          $this->authorize('updatebyUser', $transaction);
        } else if ($type == "group") {
          $user = User::find(Auth::user()->id);
          $exists = $user->groups->contains($transaction->transactionable_id);
          if ($transaction->transactionable_type != "App\Entities\Group") {
            abort(403, 'Unauthorized action.');
          } else if (!$exists) {
            abort(403, 'Unauthorized action.');
          }
        }
      } else {
        abort(403, 'Unauthorized action.');
      }
      $date = Carbon::now()->setTimezone('Asia/Jakarta');

      if ($transaction->date != $date->toDateString()) {
        abort(403, [
          "errors" => [
            "amount" => "The change time is up."
          ]
        ]);
      }

      $this->validate($request, [
        'status'      => 'required|in:plus,minus',
        'amount'      => 'required|integer',
        'description' => 'nullable',
        // 'time'        => 'required',
      ]);

      if ($type == "user") {
        $class = User::find(Auth::user()->id);

        if ($request->status == "minus") {
          if ($class->balance <= $request->amount || ($class->balance <= $transaction->amount && $transaction->amount != $request->amount)) {
            return response()->json([
              "errors" => [
                "amount" => "Your balance is insufficient."
              ]
            ], 422);
          }
        }
      } else if ($type == "group") {
        $class = $group;

        if ($request->status == "minus") {
          if ($class->balance <= $request->amount || ($class->balance <= $transaction->amount && $transaction->amount != $request->amount)) {
            return response()->json([
              "errors" => [
                "amount" => "The group balance is insufficient."
              ]
            ], 422);
          }
        }
      }

      $oldAmount = $transaction->amount;

      $transaction->status = $request->get('status', $transaction->status);
      $transaction->amount = $request->get('amount', $transaction->amount);
      $transaction->description = $request->get('description', $transaction->description);
      $transaction->time = $request->get('time', $transaction->time);

      if ($request->status == "minus") {
        if ($oldAmount != $request->amount) {
          $count = $request->amount - $oldAmount;
          if ($count >= 0) {
            $class->balance = $class->balance - $count;
          } else {
            $count = str_replace('-', '', $count);
            $class->balance = $class->balance + (int)$count;
          }
        }
      } else if ($request->status == "plus") {
        if ($transaction->status == $request->status) {
          $class->balance = $class->balance - $oldAmount;
        }
        $class->balance = $class->balance + $request->amount;
        if ($class->balance < 0) {
          return response()->json([
            "errors" => [
              "amount" => "Balance is insufficient."
            ]
          ], 422);
        }
      }

      $transaction->save();
      $class->save();

      $response = fractal()
                    ->item($transaction)
                    ->transformWith(new TransactionTransformer)
                    ->toArray();

      return response()->json($response, 201);
    }

    public function delete($type, Group $group, Transaction $transaction)
    {
      if (Auth::user()->id == $transaction->created_by) {
        if ($type == "user") {
          $this->authorize('updatebyUser', $transaction);
        } else if ($type == "group") {
          $user = User::find(Auth::user()->id);
          $exists = $user->groups->contains($transaction->transactionable_id);
          if ($transaction->transactionable_type != "App\Entities\Group") {
            abort(403, 'Unauthorized action.');
          } else if (!$exists) {
            abort(403, 'Unauthorized action.');
          }
        }
      } else {
        abort(403, 'Unauthorized action.');
      }

      $transaction->delete();

      if ($type == "user") {
        $class = User::find($transaction->transactionable_id);
      } else if ($type == "group") {
        $class = User::find($transaction->transactionable_id);
      }

      if ($transaction->status == "minus") {
        $class->balance = $class->balance + $transaction->amount;
      } else if ($transaction->status == "plus") {
        $class->balance = $class->balance - $transaction->amount;
      }

      $class->save();

      return response()->json([
        "message" => "Transaction deleted",
      ]);
    }

    public function today($type, Group $group, Transaction $transaction)
    {
      $date = Carbon::now()->setTimezone('Asia/Jakarta');
      if ($type == "user") {
        // $this->authorize('showByUser', $transaction);
        $transaction = $transaction->where([
          ['date', $date->toDateString()],
          ['transactionable_id', Auth::user()->id],
          ['transactionable_type', "App\Entities\User"],
        ]);
      } else if ($type == "group") {
        $this->authorize('authorization', $group);
        $transaction = $transaction->where([
          ['date', $date->toDateString()],
          ['transactionable_id', $group->id],
          ['transactionable_type', "App\Entities\Group"],
        ]);
      }
      $transactions = $transaction->orderBy('time', 'desc')->get();

      $response = fractal()
                    ->collection($transactions)
                    ->transformWith(new AllTransactionTransformer)
                    ->toArray();

      return response()->json($response);
    }

    public function byDate($type, $date, Group $group, Transaction $transaction)
    {
      if ($type == "user") {
        $this->authorize('showByUser', $transaction);
        $transaction = $transaction->where([
          ['date', $date],
          ['transactionable_id', Auth::user()->id],
          ['transactionable_type', "App\Entities\User"],
        ]);
      } else if ($type == "group") {
        $this->authorize('authorization', $group);
        $transaction = $transaction->where([
          ['date', $date],
          ['transactionable_id', $group->id],
          ['transactionable_type', "App\Entities\Group"],
        ]);
      }
      $transactions = $transaction->get();

      $response = fractal()
                    ->collection($transactions)
                    ->transformWith(new TransactionTransformer)
                    ->toArray();

      return response()->json($response);
    }

  public function searchSelf(Request $request)
  {
    $this->validate($request, [
      'value' => 'required'
    ]);

    $user = Auth::user()->transactions();

    $datas = $user
      ->where('description', 'like', '%' . $request->value . '%')
      ->get();

      $response = fractal()
                    ->collection($datas)
                    ->transformWith(new TransactionTransformer)
                    ->toArray();

    return response()->json($response, 201);
  }

  public function searchGroup(Group $group, Request $request)
  {
    $this->authorize('authorization', $group);
    $this->validate($request, [
      'value' => 'required'
    ]);

    $transactions = $group->transactions();

    $datas = $transactions
        ->where('description', 'like', '%' . $request->value . '%')
        ->orWhere('amount', $request->value)
        ->get();

    $response = fractal()
                  ->collection($datas)
                  ->transformWith(new AllTransactionTransformer)
                  ->toArray();

    return response()->json($response, 201);
  }
}
