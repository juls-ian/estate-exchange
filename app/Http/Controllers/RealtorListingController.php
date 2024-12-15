<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class RealtorListingController extends Controller
{

    use AuthorizesRequests;
    public function index(Request $request)
    {
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order']) # unpacks this array
        ];
        $user = $request->user(); # current auth user
        $listings = $user->listings() #eloquent relationship
            ->filter($filters)
            ->withCount('images') # count related images for listing
            ->withCount('offers') # count related offers for listing
            ->paginate(6)
            ->withQueryString(); #maintain query params

        return inertia(
            'Realtor/RealtorIndex',
            [
                'filters' => $filters,
                'listings' => $listings
            ]
        );
    }

    public function show(Listing $listing)
    {
        return inertia(
            'Realtor/ShowOffers',   # Listing    Offer relationship
            ['listing' => $listing->load('offers', 'offers.bidder')] // loading all bidder in the offers
        );
    }

    public function create()
    {
        return inertia('Realtor/CreateListing');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListingRequest $request)
    {
        //                     from ListingPolicy
        try {
            $this->authorize('create', Listing::class);
        } catch (AuthorizationException $e) {
            abort(403, 'You are not authorized to create a listing.');
        }

        # current user ()->method from user 
        // Auth::user()->listings()->create($request->validated());
        $request->user()->listings()->create($request->validated());

        return redirect()->route('realtor.listing.index')
            ->with('success', 'Listing has been added');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Listing $listing)
    {
        #         ListingPolicy
        $this->authorize('update', $listing);
        return inertia(
            'Realtor/EditListing',
            ['listing' => $listing]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingRequest $request, Listing $listing)
    {
        #         ListingPolicy
        $this->authorize('update', $listing);
        $listing->update($request->validated());
        return redirect()->route('realtor.listing.index')
            ->with('success', 'Listing was updated');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Listing $listing)
    {
        try {
            $this->authorize('delete', $listing); # connecting to ListingPolicy
        } catch (AuthorizationException $e) {
            abort(403, 'You are not authorized to delete this listing.');
        }
        $listing->delete();
        return redirect()->back()
            ->with('success', 'Listing was deleted');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();

        return redirect()->back()->with('success', 'Listing restored');
    }
    /*
    # WAY 2
    public function index()
    {

        return inertia(
            'Realtor/RealtorIndex',
            # current authenticated user obj    User model method
            ['listings' => Auth::user()->listings()]
        );
    }


    */
}