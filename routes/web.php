<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'portofolio')->name('portofolio');
Route::view('/info', 'info')->name('info');

// Alias agar akses /portofolio juga tetap bekerja
Route::redirect('/portofolio', '/', 301);

// ==========================================
// ROUTE UNTUK ADMIN PANEL SHOWCASE
// ==========================================

// 1. Halaman Index (Tabel Daftar Showcase)
Route::get('/admin/showcase', function () {
    return view('admin.showcase.index');
});

// 2. Halaman Create (Form Tambah Data)
Route::get('/admin/showcase/create', function () {
    return view('admin.showcase.create');
});

// 3. Halaman Edit (Form Ubah Data)
// {id} adalah parameter untuk ID project nantinya (contoh: /admin/showcase/1/edit)
Route::get('/admin/showcase/{id}/edit', function ($id) {
    return view('admin.showcase.edit');
});

// ==========================================
// ROUTE UNTUK ADMIN PANEL SELECTED CLIENTS
// ==========================================

Route::get('/admin/clients', function () {
    return view('admin.client.index');
});

Route::get('/admin/clients/create', function () {
    return view('admin.client.create');
});

Route::get('/admin/clients/{id}/edit', function ($id) {
    return view('admin.client.edit');
});

// ==========================================
// ROUTE UNTUK ADMIN PANEL ABOUT ME (INFO)
// ==========================================

Route::get('/admin/about', function () {
    return view('admin.about.index');
});

Route::get('/admin/about/create', function () {
    return view('admin.about.create');
});

Route::get('/admin/about/{id}/edit', function ($id) {
    return view('admin.about.edit');
});

// ==========================================
// ROUTE UNTUK ADMIN PANEL EXPERIENCE
// ==========================================

Route::get('/admin/experience', function () {
    return view('admin.experience.index');
});

Route::get('/admin/experience/create', function () {
    return view('admin.experience.create');
});

Route::get('/admin/experience/{id}/edit', function ($id) {
    return view('admin.experience.edit');
});

// ==========================================
// ROUTE UNTUK ADMIN PANEL FRIENDS
// ==========================================

Route::get('/admin/tools', function () {
    return view('admin.tools.index');
});

Route::get('/admin/tools/create', function () {
    return view('admin.tools.create');
});

Route::get('/admin/tools/{id}/edit', function ($id) {
    return view('admin.tools.edit');
});

// ==========================================
// ROUTE UNTUK LOGIN ADMIN
// ==========================================
Route::get('/login', function () {
    return view('admin.login');
})->name('login');

// ==========================================
// ROUTE UNTUK Gallery
// ==========================================
Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');