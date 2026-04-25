<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\GalleryController;

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
        $projects = \App\Models\Project::orderBy('order')->get();
        return view('admin.work.showcase', compact('projects'));
    })->name('admin.showcase');

    Route::get('/work/selected-client', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        $clients = \App\Models\Client::latest()->get();
        return view('admin.work.selected-client', compact('clients'));
    })->name('admin.clients');

    // CRUD Projects
    Route::post  ('/work/projects',           [ProjectController::class, 'store'])  ->name('admin.projects.store');
    Route::put   ('/work/projects/{project}',  [ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/work/projects/{project}',  [ProjectController::class, 'destroy'])->name('admin.projects.destroy');

    // CRUD Clients
    Route::post  ('/work/clients',            [ClientController::class, 'store'])  ->name('admin.clients.store');
    Route::put   ('/work/clients/{client}',    [ClientController::class, 'update'])->name('admin.clients.update');
    Route::delete('/work/clients/{client}',    [ClientController::class, 'destroy'])->name('admin.clients.destroy');

    Route::get('/info/about-me', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        $stories = \App\Models\Story::orderBy('order')->get();
        return view('admin.info.about-me', compact('stories'));
    })->name('admin.about');

    Route::get('/info/experience', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        $experiences = \App\Models\Experience::orderBy('start_year', 'desc')->get();
        return view('admin.info.experience', compact('experiences'));
    })->name('admin.experience');

    Route::get('/info/tools', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        $tools = \App\Models\Tool::latest()->get();
        return view('admin.info.tools', compact('tools'));
    })->name('admin.tools');

    // CRUD Stories
    Route::post  ('/info/stories',          [StoryController::class, 'store'])  ->name('admin.stories.store');
    Route::put   ('/info/stories/{story}',   [StoryController::class, 'update'])->name('admin.stories.update');
    Route::delete('/info/stories/{story}',   [StoryController::class, 'destroy'])->name('admin.stories.destroy');

    // CRUD Experiences
    Route::post  ('/info/experiences',              [ExperienceController::class, 'store'])  ->name('admin.experiences.store');
    Route::put   ('/info/experiences/{experience}',  [ExperienceController::class, 'update'])->name('admin.experiences.update');
    Route::delete('/info/experiences/{experience}',  [ExperienceController::class, 'destroy'])->name('admin.experiences.destroy');

    // CRUD Tools
    Route::post  ('/info/tools-item',       [ToolController::class, 'store'])  ->name('admin.tools.store');
    Route::put   ('/info/tools-item/{tool}', [ToolController::class, 'update'])->name('admin.tools.update');
    Route::delete('/info/tools-item/{tool}', [ToolController::class, 'destroy'])->name('admin.tools.destroy');

    // CRUD Gallery
    Route::post  ('/gallery-item',           [GalleryController::class, 'store'])  ->name('admin.gallery.store');
    Route::put   ('/gallery-item/{gallery}',  [GalleryController::class, 'update'])->name('admin.gallery.update');
    Route::delete('/gallery-item/{gallery}',  [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

    Route::get('/gallery', function () {
        if (!session('admin_logged_in')) return redirect('/login');
        $images = \App\Models\Gallery::latest()->get();
        return view('admin.gallery.gallery', compact('images'));
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