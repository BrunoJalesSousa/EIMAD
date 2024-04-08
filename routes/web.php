<?php

use App\Http\Controllers\accounts\AccountViewsController;
use App\Http\Controllers\authentications\AuthController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\video_stream\VideoStreamController;
use Illuminate\Http\Request;

use App\Http\Controllers\media\MediaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;

// Main Page Route
Route::get('/login', [LoginBasic::class, 'index'])->name('user-login');
Route::get('/register', [RegisterBasic::class, 'index'])->name('user-register');

// Temporary main page
Route::get('/1', [Analytics::class, 'index'])->name('dashboard-analytics')->middleware('auth');

// Login routes
Route::post('/register-user', [AuthController::class, 'register'])->name('register-user');
Route::post('/login-user', [AuthController::class, 'login'])->name('login-user');
Route::get('/logout-user', [AuthController::class, 'logout'])->name('logout-user');
Route::post('/register-account', [AuthController::class, 'registerAccount'])->name('register-account');
Route::post('/show-password', [AuthController::class, 'showPassword'])->name('show-password');

// Users routes
Route::get('/accounts', [AccountViewsController::class, 'index'])->name('users')->middleware('auth');
Route::get('/accounts/add', [AccountViewsController::class, 'add'])->name('add-account')->middleware('auth');

// Media routes
Route::get('/media/videos', [MediaController::class, 'videos'])->name('media-videos')->middleware('auth');
Route::post('/media/del-video/{slug}', [MediaController::class, 'delvideo'])->name('media-delvideo')->middleware('auth');
Route::post('/media/del-all-videos', [MediaController::class, 'delAllVideos'])->name('media-delAllVideos')->middleware('auth');
Route::Resource('/video_stream', VideoStreamController::class)->middleware('auth');

// CLI Routes
Route::get('media/play/{command}', [ProcessController::class, 'playVideo'])->name('play-video')->middleware('auth');


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

  Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
