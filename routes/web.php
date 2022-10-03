<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\SettingsController;
use App\Http\Resources\BlogResource;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'blogs' => BlogResource::collection(auth()->user()->blogs()->paginate()),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('blogs/create', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('blogs/{blog}', [BlogController::class, 'show'])
        ->name('blogs.show')
        ->withoutMiddleware('auth');
    Route::get('blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('blogs/{blog}/edit', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');


    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::post('settings/password', [SettingsController::class, 'password'])->name('settings.password');
});

require __DIR__ . '/auth.php';
