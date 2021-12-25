<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
/* =============== My Custom Route =============== */
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\BannerInfoController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

/* ============================ My Custom Route ============================ */
Route::group(['prefix'=>'admin','middleware' =>['auth:sanctum'] ], function(){
  Route::get('dashboard',[AdminController::class, 'index'])->name('admin.dashboard');

  /* ========== Company Profile ========== */
  Route::get('company/profile', [CompanyProfileController::class, 'profile'])->name('company-profiles');
  Route::post('company/profile/update', [CompanyProfileController::class, 'updateProfile'])->name('update-profile');
  /* ========== Banner Information ========== */
  Route::get('banner/information', [BannerInfoController::class, 'index'])->name('banner-info');
  Route::get('banner/information/add', [BannerInfoController::class, 'add'])->name('add-banner-info');
  Route::get('banner/information/edit/{ban_id}', [BannerInfoController::class, 'edit'])->name('edit-banner-info');
  Route::get('banner/information/delete/{ban_id}', [BannerInfoController::class, 'delete'])->name('delete-banner-info');
  Route::post('banner/information/insert', [BannerInfoController::class, 'insert'])->name('insert-banner-info');
  Route::post('banner/information/update', [BannerInfoController::class, 'update'])->name('update-banner-info');

  /* ______________________ +++++ ______________________ */
});
