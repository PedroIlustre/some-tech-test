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


Auth::routes();
// Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/upload_file', 'UploadFileController@uploadFile')->name('upload_file');
Route::post('/save_contact', 'UploadFileController@save')->name('save_contact');
Route::post('/save_contact_data', 'ContactController@save')->name('save_contact_data');