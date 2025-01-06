<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return inertia('index/Index');
// });

# Index Controller

Route::get('/', [ListingController::class, 'index']);

# Listing Routes
Route::resource('listing', ListingController::class)
    ->only(['index', 'show']);

# Offer Routes 
Route::resource('listing.offer', ListingOfferController::class)
    ->middleware('auth')->only(['store']);

# Notification Route 
Route::resource('notification', NotificationController::class)
    ->middleware('auth')
    ->only(['index']);
Route::put('notification/{notification}/seen', NotificationSeenController::class)
    ->name('notification.seen')
    ->middleware('auth');

# Login Routes
Route::get('login', [AuthController::class, 'create'])
    ->name('login'); #alias
Route::post('login', [AuthController::class, 'store'])
    ->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])
    ->name('logout');

# Verification Routes
Route::get('/email/verify', function () {
    return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('listing.index')->with('success', 'Email successfully verified');
})->middleware(['auth', 'signed'])->name('verification.verify');
# resend verification route 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return redirect()->back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


# Register Route
Route::resource('user', UserAccountController::class);


# Realtor Routes (routes grouped)
Route::prefix('realtor')
    ->name('realtor.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        # Restore listing route 
        Route::name('listing.restore')
            # use http put 
            ->put(
                'listing/{listing}/restore',
                [RealtorListingController::class, 'restore']
            )->withTrashed(); #retrieve deleted
        # Realtor Listing resource routes
        Route::resource('listing', RealtorListingController::class)
            ->withTrashed();
        # Listing Image route
        Route::resource('listing.image', RealtorListingImageController::class)
            ->only(['create', 'store', 'destroy']);
        # Accept Offer route
        Route::name('offer.accept')
            ->put('offer/{offer}/accept', RealtorAcceptOfferController::class);
    });



/*
# Listing Routes
Route::resource('listing', ListingController::class)
    ->only(['create', 'store'])
    ->middleware('auth'); #authenticated routes ~ if not auth redirect to log in 
# Leaves out the index and show  
Route::resource('listing', ListingController::class)
    ->except(['create', 'store', 'edit', 'update', 'destroy']);
    */