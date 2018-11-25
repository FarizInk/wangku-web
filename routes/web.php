<?php
use Carbon\Carbon;
use App\Entities\Transaction;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landingpage');
});
Route::get('/new-admin', function () {
    return view('new-admin.groups');
});

// Route::get('/test', function () {
    // $dt = Carbon::now()->setTimezone('Asia/Singapore');
    // echo $dt->toTimeString();

    // $user = User::find(1);
    // $exists = $user->groups->contains(2);
    // $date = Carbon::now();

    // $user = User::find(1);
    // echo $user->transactions->where([
    //   ['date', $date->toDateString()],
    //   ['transactionable_type', "App\Entities\User"]
    // ]);

    // $transaction = Transaction::where([
    //   ['date', $date->toDateString()],
    //   ['transactionable_id', "1"],
    //   ['transactionable_type', "App\Entities\User"],
    // ]);

    // return $transaction->get();

// });

Auth::routes();
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/profile', 'UserController@profile')->name('profile');
Route::get('/home', function()
{
  return redirect('dashboard');
});

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
  Route::get('/', 'DashboardController@index')->name('index');
  Route::get('/profile-card/{id}', 'UsersController@profileCard')->name('profile.card');
  Route::get('/users', 'UsersController@index')->name('users');
  Route::get('/users/banned', 'UsersController@banned')->name('users.banned');
  Route::post('/user/delete', 'UsersController@delete')->name('user.delete');
  Route::post('/user/banned', 'UsersController@softDelete')->name('user.softDelete');
  Route::post('/user/unban', 'UsersController@unban')->name('user.unban');
  Route::get('/user/{id}', 'UsersController@edit')->name('user.edit');
  Route::post('/user/{id}', 'UsersController@update')->name('user.update');
  Route::get('/transaction', 'TransactionController@index')->name('transaction');
  Route::get('/groups', 'GroupsController@index')->name('groups');
});
