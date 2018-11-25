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

        if ($request->status == "minus") {
          if ($class->balance <= $request->amount) {
            return response()->json([
              "errors" => [
                "amount" => ["Your balance is insufficient."]
              ]
            ], 422);
          }
        }

        if ($class->metadata->region == "west") {
          $date = Carbon::now()->setTimezone('Asia/Jakarta');
        } else if ($class->metadata->region == "middle") {
          $date = Carbon::now()->setTimezone('Asia/Singapore');
        } else if ($class->metadata->region == "east") {
          $date = Carbon::now()->setTimezone('Asia/Tokyo');
        }
      } else if ($type == "group") {
        $this->authorize('authorization', $group);
        $class = $group;

        if ($request->status == "minus") {
          if ($class->balance <= $request->amount) {
            return response()->json([
              "errors" => [
                "amount" => ["The Group balance is insufficient."]
              ]
            ], 422);
          }
        }

        if ($group->region == "west") {
          $date = Carbon::now()->setTimezone('Asia/Jakarta');
        } else if ($group->region == "middle") {
          $date = Carbon::now()->setTimezone('Asia/Singapore');
        } else if ($group->region == "east") {
          $date = Carbon::now()->setTimezone('Asia/Tokyo');
        }
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
        ])->orderBy('created_at', 'desc')->get();
      } else if ($type == "group") {
        $this->authorize('authorization', $group);
        $class = Transaction::where([
          ['transactionable_id', '=', $group->id],
          ['transactionable_type', '=', "App\\Entities\\Group"]
        ])->orderBy('created_at', 'desc')->get();
      }

      $response = fractal()
                    ->collection($class)
                    ->transformWith(new TransactionTransformer)
                    ->toArray();

      return response()->json($response);
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
                    ->transformWith(new TransactionTransformer)
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
        abort(403, 'The change time is up.');
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
          if ($class->balance <= $request->amount) {
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
          if ($class->balance <= $request->amount) {
            return response()->json([
              "errors" => [
                "amount" => "The group balance is insufficient."
              ]
            ], 422);
          }
        }
      }

      $transaction->status = $request->get('status', $transaction->status);
      $transaction->amount = $request->get('amount', $transaction->amount);
      $transaction->description = $request->get('description', $transaction->description);
      $transaction->time = $request->get('time', $transaction->time);
      $transaction->save();

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

      return response()->json([
        "mesaage" => "Transaction deleted",
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
                    ->transformWith(new TransactionTransformer)
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
}