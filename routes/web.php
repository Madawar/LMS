<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HolidayController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('leave', LeaveController::class)->middleware(['auth','staffverified']);
Route::resource('department', DepartmentController::class)->middleware(['auth','staffverified']);
Route::resource('insight', InsightController::class)->middleware(['auth','staffverified']);
Route::resource('notification', NotificationController::class)->middleware(['auth','staffverified']);
Route::resource('staff', StaffController::class)->middleware(['auth','staffverified']);
Route::resource('profile', ProfileController::class)->middleware(['auth','staffverified']);
Route::resource('holiday', HolidayController::class)->middleware(['auth','staffverified']);
Route::get('/toword/{id}', [LeaveController::class, 'toWord'])->middleware(['auth','staffverified']);
