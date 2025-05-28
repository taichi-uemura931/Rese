<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOwnerController;
use App\Http\Controllers\Admin\AdminEmailController;
use App\Http\Controllers\Owner\OwnerRestaurantController;
use App\Http\Controllers\Owner\OwnerReservationController;
use App\Http\Controllers\Owner\OwnerLoginController;
use App\Http\Controllers\Owner\OwnerDashboardController;

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

Route::get('/', [ShopController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'detail'])->name('shop.detail');

Route::get('/search', [ShopController::class, 'search'])->name('shop.search');

Route::middleware('auth')->group(function () {
    Route::post('/favorite/{restaurant}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

    Route::post('/reserve', [ShopController::class, 'reserve'])->name('shop.reserve');
    Route::post('/purchase', [PurchaseController::class, 'purchase'])->name('purchase');

    Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'destroy'])->name('reservations.cancel');
    Route::post('/reservations/{id}/update', [ReservationController::class, 'update'])->name('reservations.update');

    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::get('/verify/{token}', [ReservationVerificationController::class, 'verify'])->name('reservation.verify');
    Route::get('/mypage/verify/{reservation}', [MypageController::class, 'showQrCode'])->name('mypage.verify');

    Route::get('/mypage/review/{reservation_id}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/mypage/review/{reservation_id}', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('register.thanks');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function () {
        request()->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/register/thanks', fn () => view('auth.thanks'))->name('register.thanks');
});

Route::get('/restaurants/{id}/reviews', [ReviewController::class, 'restaurantReviews'])->name('restaurant.reviews');

Route::get('/done', fn () => view('done'))->name('done');

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);

Route::get('/owner/login', [OwnerLoginController::class, 'showLoginForm'])->name('owner.login');
Route::post('/owner/login', [OwnerLoginController::class, 'login']);

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('owners', AdminOwnerController::class);
    Route::get('/email/form', [AdminEmailController::class, 'form'])->name('email.form');
    Route::post('/email/send', [AdminEmailController::class, 'send'])->name('email.send');
});

Route::prefix('owner')->middleware(['auth', 'owner'])->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('restaurants', OwnerRestaurantController::class)->except(['show', 'destroy']);
    Route::post('/reservations/{id}/visited-toggle', [OwnerReservationController::class, 'toggleVisited'])
    ->name('reservations.toggleVisited');
    Route::get('/reservations', [OwnerReservationController::class, 'index'])->name('reservations.index');
    Route::get('/verify/{token}', [OwnerReservationController::class, 'verifyQr'])->name('verify.qr');
    Route::get('/restaurants/{id}/reviews', [OwnerRestaurantController::class, 'reviews'])->name('restaurants.reviews');
    Route::post('/reservations/{id}/cancel', [OwnerReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('/reservations', [OwnerReservationController::class, 'index'])->name('reservations.index');
});



