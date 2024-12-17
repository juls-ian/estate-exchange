<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Notifications\OfferMade;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListingOfferController extends Controller
{
    use AuthorizesRequests;
    public function store(Listing $listing, OfferRequest $request)
    {
        // ListingPolicy, must be auth to see offer
        $this->authorize('view', $listing);
        // Pass the user and the listing to the sendOffer policy method
        // $this->authorize('sendOffer', [$request->user(), $listing]);


        // Make offer
        $offer = $listing->offers()->save(
            // Create model doesn't store immediately
            Offer::make($request->validated())
                // ensure offer is made by user 
                ->bidder()->associate($request->user())
        );
        // Save the notification
        $listing->owner->notify(
            // OfferModel parameter is the constructor
            new OfferMade($offer)
        );

        return redirect()->back()->with('success', 'Offer was made!');
    }

    /*
    public function store(Listing $listing, Request $request)
    {
        $listing->offers()->save(
            // Create model doesn't store immediately
            Offer::make($request->validate([
                'amount' => 'required|integer|min:1|max:20000000'
            ]))
                // ensure offer is made by user 
                ->bidder()->associate($request->user())
        );
        return redirect()->back()->with('success', 'Offer made!');
    }
        */
}