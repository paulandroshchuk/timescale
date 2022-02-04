<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/siege/activity-0', function () {
    return \App\Models\Activity::query()
        ->where('account_id', 1)
        ->where('activity_type', ['ACTIVITY_OPT_IN', 'ACTIVITY_OPT_OUT', 'TEXT'][rand(0, 2)])
        ->whereBetween('created_at', [
            now()->subWeeks(2),
            now()->subWeek(),
        ]);
});

Route::get('/siege/activity-1', function () {
    return \App\Models\Activity::query()
        ->where('account_id', 1)
        ->whereBetween('created_at', [
            now()->subWeeks(2),
            now()->subWeek(),
        ]);
});

Route::get('/siege/activity-1', function () {
    return \App\Models\Activity::query()
        ->whereBetween('created_at', [
            now()->subWeeks(2),
            now()->subWeek(),
        ]);
});

Route::get('/siege/activity-1', function () {
    return \App\Models\Activity::query()
        ->whereBetween('created_at', [
            now()->subWeeks(2),
            now()->subWeek(),
        ]);
});

Route::post('/siege/activity-1', function () {
    return \App\Models\Activity::create([
        'account_id' => rand(1, 5_000),
        'subscriber_id' => rand(1, 2_000_000),
        'activity_type' => ['ACTIVITY_OPT_IN', 'ACTIVITY_OPT_OUT', 'TEXT'][rand(0, 2)],
        'activity_data' => '{"type": "Some data here.", "uuid": "4261b720-9568-48d8-81ca-3cda48905ca8", "user_id": 892, "message_id": 205403, "another_one": "7rxn6abhB5V1r8nNTxqV31w68lrb5q0UhFSH2KKk2ul7tWbvO3"}',
    ]);
});
