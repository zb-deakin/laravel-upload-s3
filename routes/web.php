<?php

use App\Jobs\SendUploadNotificationMailJob;
use App\Mail\UploadNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

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

Route::get('/', [DocumentController::class, 'index'])->name('home');
Route::post('/', [DocumentController::class, 'store']);

Route::get('/view-document/{document}', [DocumentController::class, 'show']);
