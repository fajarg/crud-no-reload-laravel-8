<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\LoginController;
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

Route::get('/', [LoginController::class, 'index']);
Route::get('valid', [LoginController::class, 'valid']);
Route::get('students', [StudentController::class, 'index']);
Route::get('fetch-students', [StudentController::class, 'fetchstudent']);
Route::post('students', [StudentController::class, 'store']);
Route::get('edit-student/{id}', [StudentController::class, 'edit']);
Route::put('update-student/{id}', [StudentController::class, 'update']);
Route::delete('delete-student/{id}', [StudentController::class, 'destroy']);

// Route::get('/', function () {
//     return view('welcome');
// });
