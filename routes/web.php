<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::post('employee/bulk-delete', [EmployeeController::class, 'bulkDelete']);
Route::get('employee/load-table', [EmployeeController::class, 'loadEmployeesTable']);
Route::resource('employee', EmployeeController::class)->only([
    'index',
    'create',
    'store',
    'update'
]);