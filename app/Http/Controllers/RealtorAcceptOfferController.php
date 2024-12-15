<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RealtorAcceptOfferController extends Controller
{
    use AuthorizesRequests;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Offer $offer)
    {                       #relationship
        $listing = $offer->listing; # Get the related listing model
        $this->authorize('update', $listing);
        // Accept selected offer 
        $offer->update(['accepted_at' => now()]); # update accepted_at col 

        // set sold_at col to current date/time 
        $listing->sold_at = now();  # update sold_at col 
        $listing->save(); // save Listing 

        // Reject all other offers
        $offer->listing->offers()->except($offer)
            ->update(['rejected_at' => now()]); # now() = current date

        return redirect()->back()
            ->with('success', "Offer #{$offer->id} accepted, other offers rejected");
    }
}