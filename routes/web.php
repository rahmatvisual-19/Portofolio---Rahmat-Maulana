<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'portofolio')->name('portofolio');
Route::view('/info', 'info')->name('info');

// Alias agar akses /portofolio juga tetap bekerja
Route::redirect('/portofolio', '/', 301);
