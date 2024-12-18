<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;
use App\Models\Listing;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ListingController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Listing $listing)
    {
        $this->authorize('view', $listing);

        # filters variable  
        $filters = $request->only([
            'priceFrom',
            'priceTo',
            'beds',
            'baths',
            'areaFrom',
            'areaTo'
        ]);

        return inertia(
            'Listing/ListingIndex',
            [
                'filters' => $filters,
                'listings' => Listing::mostRecent() #query only executed with paginate method
                    ->filter($filters) #scopeFilter
                    ->unsold() # exclude sold listing
                    ->excludeOwned()
                    /*
                    ->when(Auth::check(), function ($query) {
                        return $query->where('owner_id', '!=', Auth::id());
                    })
                        */
                    ->paginate(12) # returns an object
                    ->withQueryString() # keep the url when paginating
            ]

        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $this->authorize('view', $listing);

        $listing->load(['images']); # load relationship 
        $offer = !Auth::user() ? null : $listing->offers()->byMe()->first();
        return inertia(
            'Listing/ShowListing',
            [
                'listing' => $listing,
                'offerMade' => $offer
            ]
            // ['listing' => Listing::find($id)]
        );
    }


}