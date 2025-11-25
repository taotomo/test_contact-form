<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CsvDownloadController;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [ContactController::class, 'index'])->name("rewrite");

Route::post('/confirm', [ContactController::class, 'confirm']);

Route::post('/thanks', [ContactController::class, 'store']);

Route::get('/register', [AuthController::class, 'registerView']);

Route::get('/login', [AuthController::class, 'loginView']);

Route::middleware('auth')->group(function () {
    Route::get('/admin', [ContactController::class, 'admin']);
});

Route::get('/admin/search', [ContactController::class, 'search']);

Route::post('/admin/delete', [ContactController::class, 'delete']);

Route::get('/admin/csv-download', [CsvDownloadController::class, 'downloadCsv']);