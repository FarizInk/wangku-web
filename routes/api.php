<?php

use Illuminate\Http\Request;

Route::namespace('Api')->group(function () {
  Route::post('register', 'AuthController@register');
  Route::post('login', 'AuthController@login');

  Route::get('recordday/{region}/{key}', 'DayRecordController@record');
  Route::get('recordmonth/{region}/{key}', 'MonthRecordController@record');

  Route::get('search/user/{user}', 'UserController@userById');
  Route::post('search/user', 'UserController@userByEmail');

  Route::middleware('auth:api')->group(function () {
    Route::get('check', 'UserController@checkApi');
    Route::get('profile', 'UserController@profile');
    Route::put('profile/update', 'UserController@update');
    Route::post('profile/update/email', 'UserController@updateEmail');
    Route::post('profile/update/password', 'UserController@updatePassword');
    Route::post('profile/update/photo', 'UserController@updatePhoto');
    Route::get('datenow', 'UserController@datenow');
    Route::get('profile/sendemail', 'UserController@sendemail');

    Route::get('transactions/date/{type}/{date}', 'TransactionController@byDate');
    Route::get('transactions/date/{type}/{date}/{group}', 'TransactionController@byDate');
    Route::get('transactions/today/{type}', 'TransactionController@today');
    Route::get('transactions/today/{type}/{group}', 'TransactionController@today');
    Route::get('transactions/{type}', 'TransactionController@showAll');
    Route::get('transactions/{type}/{group}', 'TransactionController@showAll');

    Route::post('transaction/{type}', 'TransactionController@add');
    Route::post('transaction/{type}/{group}', 'TransactionController@add');
    Route::get('transaction/{type}/{transaction}', 'TransactionController@show');  Route::get('transaction/{type}/{group}/{transaction}', 'TransactionController@show');
    Route::put('transaction/{type}/{transaction}', 'TransactionController@update');
    Route::put('transaction/{type}/{group}/{transaction}', 'TransactionController@update');
    Route::delete('transaction/{type}/{transaction}', 'TransactionController@delete');
    Route::delete('transaction/{type}/{group}/{transaction}', 'TransactionController@delete');

    Route::get('record/day/{type}', 'DayRecordController@show');
    Route::get('record/day/{type}/{group}', 'DayRecordController@show');
    Route::get('record/month/{type}', 'MonthRecordController@show');
    Route::get('record/month/{type}/{group}', 'MonthRecordController@show');

    Route::get('groups', 'GroupController@showAll');
    Route::post('group', 'GroupController@add');
    Route::get('group/member/{group}', 'GroupController@showMember');
    Route::get('group/{group}', 'GroupController@show');
    Route::put('group/{group}', 'GroupController@update');
    Route::delete('group/{group}', 'GroupController@delete');
    Route::post('group/{group}/addmember', 'GroupController@addMember');
    Route::post('group/{group}/removemember', 'GroupController@removeMember');
    Route::post('group/{group}/leave', 'GroupController@leave');
    Route::post('group/{group}/photo', 'GroupController@updatePhoto');

    Route::post('search/transactions/self', 'TransactionController@searchSelf');
    Route::post('search/transactions/{group}', 'TransactionController@searchGroup');

    Route::get('home', 'HomeController@home');
    Route::get('home/{group}', 'HomeController@homeGroup');
  });
});
