<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListingOfferController extends Controller
{
    use AuthorizesRequests;
    public function store(Listing $listing, OfferRequest $request)
    {
        // ListingPolicy, must be auth to make offer
        $this->authorize('view', $listing);
        $listing->offers()->save(
            // Create model doesn't store immediately
            Offer::make($request->validated())
                // ensure offer is made by user 
                ->bidder()->associate($request->user())
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