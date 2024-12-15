<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\RealtorAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return inertia('index/Index');
// });

# Index Controller
Route::get('/', [IndexController::class, 'index']);
Route::get('/show', [IndexController::class, 'show'])
    ->middleware('auth');


# Listing Routes
Route::resource('listing', ListingController::class)
    ->only(['index', 'show']);

#Offer Routes 
Route::resource('listing.offer', ListingOfferController::class)
    ->middleware('auth')->only(['store']);

# Login Routes
Route::get('login', [AuthController::class, 'create'])
    ->name('login'); #alias
Route::post('login', [AuthController::class, 'store'])
    ->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])
    ->name('logout');

# Register Route
Route::resource('user', UserAccountController::class);


# Realtor Routes (routes grouped)
Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth')
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