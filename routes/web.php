<?php

use App\Http\Controllers\accounts\AccountViewsController;
use App\Http\Controllers\authentications\AuthController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\video_stream\VideoStreamController;

use App\Http\Controllers\media\MediaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\DashboardController;

// Main Page Route
Route::get('/login', [LoginBasic::class, 'index'])->name('user-login');

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Login routes
Route::post('/register-user', [AuthController::class, 'register'])->name('register-user')->middleware('auth');
Route::post('/login-user', [AuthController::class, 'login'])->name('login-user');
Route::get('/logout-user', [AuthController::class, 'logout'])->name('logout-user')->middleware('auth');
Route::post('/register-account', [AuthController::class, 'registerAccount'])->name('register-account')->middleware('auth');

// Users routes
Route::get('/accounts', [AccountViewsController::class, 'index'])->name('users')->middleware('auth');
Route::get('/accounts/del/{slug}', [AccountViewsController::class, 'destroy'])->name('del-account')->middleware('auth');
Route::get('/accounts/add', [AccountViewsController::class, 'add'])->name('add-account')->middleware('auth');

// Media routes
Route::get('/media/videos', [MediaController::class, 'videos'])->name('media-videos')->middleware('auth');
Route::post('/media/del-video/{slug}', [MediaController::class, 'delvideo'])->name('media-delvideo')->middleware('auth');
Route::post('/media/del-all-videos', [MediaController::class, 'delAllVideos'])->name('media-delAllVideos')->middleware('auth');
Route::Resource('/video_stream', VideoStreamController::class)->middleware('auth');
Route::get('/media/order/{slug}/up', [VideoStreamController::class, 'orderUp'])->name('media-order-up')->middleware('auth');
Route::get('/media/order/{slug}/down', [VideoStreamController::class, 'orderDown'])->name('media-order-down')->middleware('auth');

// CLI Routes
Route::get('media/play/{slug}', [ProcessController::class, 'playVideo'])->name('play-video')->middleware('auth');
Route::get('media/loop/{slug}', [ProcessController::class, 'loopVideo'])->name('loop-video')->middleware('auth');


// layout
  Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
  Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
  Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
  Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
  Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
  Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
  Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
  Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
  Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
  Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
