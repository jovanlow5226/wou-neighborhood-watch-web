<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ManagementDashboardController;
use App\Http\Controllers\OwnerTenantDashboardController;
use App\Http\Controllers\Management\RegistrationController;
use App\Http\Controllers\Management\FacilityManagementController;
use App\Http\Controllers\Management\BookingManagementController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\Resident\FacilityController;
use App\Http\Controllers\Resident\BookingController;
use App\Http\Controllers\Resident\LostAndFoundController;


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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::match(['get', 'post'],'/logout', [LoginController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/generate-password', [PasswordController::class, 'generate'])->name('generate.password');
Route::match(['get', 'post'],'/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/management-dashboard', [ManagementDashboardController::class, 'viewDashboard'])->name('management.dashboard');
Route::match(['get', 'post'], '/ownertenant-dashboard', [OwnerTenantDashboardController::class, 'viewDashboard'])->name('ownertenant.dashboard');
Route::get('/registration', [RegistrationController::class, 'showRegisterPage'])->name('register.page');
Route::post('/register', [RegistrationController::class, 'register'])->name('register.page');
Route::get('/facility-management', [FacilityManagementController::class, 'facilityOverview'])->name('facilityOverview.page');
Route::get('/booking-management', [BookingManagementController::class, 'bookingOverview'])->name('bookingOverview.page');
Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
Route::get('/facilities/list', [FacilityController::class, 'list'])->name('facilities.list');
Route::get('/lost-and-found', [LostAndFoundController::class, 'index'])->name('lost_and_found.index');



/**Function List**/
Route::get('/get-booking-data', [BookingManagementController::class, 'getBookingDataByBookingId'])->name('bookingOverview.page');
Route::post('/community/storePost', [CommunityController::class, 'storePost'])->name('community.storePost');
Route::post('/community/storeComment/{postId}', [CommunityController::class, 'storeComment'])->name('community.storeComment');
Route::delete('/community/deletePost/{id}', [CommunityController::class, 'deletePost'])->name('community.deletePost');
Route::post('/community/likePost/{id}', [CommunityController::class, 'likePost'])->name('community.likePost');
Route::delete('/community/unlikePost/{id}', [CommunityController::class, 'unlikePost'])->name('community.unlikePost');
Route::get('/facilities/{id}', [FacilityController::class, 'show'])->name('facilities.show');
Route::post('/facilities/{id}/book', [FacilityController::class, 'book'])->name('facilities.book');
Route::get('/booking-history', [BookingController::class, 'history'])->name('bookings.history');
Route::get('/api/facilities/{id}/bookings', [FacilityController::class, 'getBookings']);
Route::put('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
Route::get('/lost-and-found/create', [LostAndFoundController::class, 'create'])->name('lost_and_found.create');
Route::post('/lost-and-found', [LostAndFoundController::class, 'store'])->name('lost_and_found.store');
Route::get('/lost-and-found/{id}', [LostAndFoundController::class, 'show'])->name('lost_and_found.show');
Route::post('/lost-and-found/search', [LostAndFoundController::class, 'search'])->name('lost_and_found.search');
Route::patch('/lost-and-found/{lostItem}/found', [LostAndFoundController::class, 'markAsFound'])->name('lost_and_found.markAsFound');
