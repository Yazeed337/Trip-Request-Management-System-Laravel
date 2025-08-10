<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\TripRequestController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinations', [HomeController::class, 'getDestinations'])->name('destinations.list');

// Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/user', [AuthController::class, 'user'])->name('auth.user');
Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('auth.profile.update');
Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('auth.password.change');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/user', [AuthController::class, 'user'])->name('user.info');

// TEST TEST TEST TEST
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
   Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
         ->name('admin.dashboard');
       Route::post('/contact-messages/{message}/mark-as-read', 
        [AdminController::class, 'markAsRead'])
        ->name('admin.contact-mark-read');
        
    Route::post('/contact-messages/{message}/mark-as-replied', 
        [AdminController::class, 'markAsReplied'])
        ->name('admin.contact-mark-replied');
    Route::post('/admin/trip-requests/{tripRequest}/update-status', 
                [AdminController::class, 'updateTripRequestStatus'])
         ->name('admin.trip-requests.update-status'); // Admin routes
          Route::get('/contact-messages', [AdminController::class, 'contactMessages'])->name('admin.contact-messages');
    Route::post('/contact-messages/{message}/mark-as-read', [AdminController::class, 'markAsRead'])->name('admin.contact-mark-read');
    Route::post('/contact-messages/{message}/mark-as-replied', [AdminController::class, 'markAsReplied'])->name('admin.contact-mark-replied');
    Route::post('/contact', [ContactMessageController::class, 'store'])
     ->name('contact.store');
});
Route::post('/contact', [ContactMessageController::class, 'store'])
     ->name('contact.store');
Route::post('/trip-requests', [TripRequestController::class, 'store'])->name('trip-requests.store');
// Public Routes
Route::post('/trip-request', [HomeController::class, 'submitTripRequest'])->name('trip.request');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::post('/recommendation', [HomeController::class, 'getRecommendation'])->name('recommendation.get');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/trip-requests', [TripRequestController::class, 'store'])
     ->name('trip-requests.store')
     ->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
  //  Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    //Route::get('/stats', [AdminController::class, 'getStats'])->name('stats');
    
    // Trip Requests Management
    Route::get('/trip-requests', [AdminController::class, 'tripRequests'])->name('trip-requests');
    Route::patch('/trip-requests/{tripRequest}/status', [AdminController::class, 'updateTripRequestStatus'])->name('trip-requests.status');
    
    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/toggle-admin', [AdminController::class, 'toggleUserAdmin'])->name('users.toggle-admin');
    
    // Destinations Management
    Route::get('/destinations', [AdminController::class, 'destinations'])->name('destinations');
    Route::post('/destinations', [AdminController::class, 'storeDestination'])->name('destinations.store');
    Route::patch('/destinations/{destination}', [AdminController::class, 'updateDestination'])->name('destinations.update');
    Route::delete('/destinations/{destination}', [AdminController::class, 'destroyDestination'])->name('destinations.destroy');
    
    // Contact Messages Management
    Route::get('/contact-messages', [AdminController::class, 'contactMessages'])->name('contact-messages');
    Route::patch('/contact-messages/{message}/read', [AdminController::class, 'markMessageAsRead'])->name('contact-messages.read');
    Route::patch('/contact-messages/{message}/replied', [AdminController::class, 'markMessageAsReplied'])->name('contact-messages.replied');
    
    // Recommendations Management
    Route::get('/recommendations', [AdminController::class, 'recommendations'])->name('recommendations');
});
