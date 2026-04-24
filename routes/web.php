<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

// ==========================================
// FRONTEND ROUTES (Sekarang menggunakan Controller)
// ==========================================

// Halaman Utama: Mengambil data Project & Client dari DB
Route::get('/', [PublicController::class, 'index'])->name('portofolio');

// Halaman Info: Mengambil data Story, Experience, & Tools dari DB
Route::get('/info', [PublicController::class, 'info'])->name('info');

// Halaman Gallery: Mengambil data foto dari DB
Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');

// Tetap simpan redirect ini untuk SEO
Route::redirect('/portofolio', '/', 301);


// ==========================================
// AUTHENTICATION ROUTES (Tetap sama untuk sementara)
// ==========================================
Route::get('/login', fn() => view('admin.login'))->name('login');

Route::post('/login', function () {
    $email    = request('email');
    $password = request('password');

    if ($email === env('ADMIN_EMAIL', 'admin@example.com') && $password === env('ADMIN_PASSWORD', 'password')) {
        session(['admin_logged_in' => true]);
        return redirect('/admin/work/showcase');
    }

    return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
});

Route::post('/logout', function () {
    session()->forget('admin_logged_in');
    return redirect('/');
})->name('logout');


// ==========================================
// ADMIN ROUTES
// ==========================================
// (Route admin ini nantinya juga akan kita hubungkan ke Controller masing-masing)
Route::prefix('admin')->group(function () {

    Route::get('/work/showcase', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        return view('admin.work.showcase');
    })->name('admin.showcase');

    Route::get('/work/selected-client', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        return view('admin.work.selected-client');
    })->name('admin.clients');

    Route::get('/info/about-me', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        return view('admin.info.about-me');
    })->name('admin.about');

    Route::get('/info/experience', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        return view('admin.info.experience');
    })->name('admin.experience');

    Route::get('/info/tools', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        return view('admin.info.tools');
    })->name('admin.tools');

    Route::get('/gallery', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        return view('admin.gallery.index');
    })->name('admin.gallery');

    Route::get('/navbar/linkedin', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        return view('admin.navbar.linkedin');
    })->name('admin.navbar.linkedin');

    Route::get('/navbar/resume', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        return view('admin.navbar.resume');
    })->name('admin.navbar.resume');

    Route::get('/navbar/cv', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        return view('admin.navbar.cv');
    })->name('admin.navbar.cv');

    Route::redirect('/', '/admin/work/showcase');
});