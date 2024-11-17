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
    public function index(Request $request)
    {
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
                    ->paginate(10) // returns an object
                    ->withQueryString() //keep the url when paginating
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $listing->load(['images']); # load relationship 
        return inertia(
            'Listing/ShowListing',
            ['listing' => $listing]
            // ['listing' => Listing::find($id)]
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Listing/CreateListing');
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

        return redirect()->route('listing.index')
            ->with('success', 'Listing has been added');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //                     from ListingPolicy
        try {
            $this->authorize('update', $listing);
        } catch (AuthorizationException $e) {
            abort(403, 'You are not authorized to edit this listing.');
        }
        return inertia(
            'Listing/EditListing',
            ['listing' => $listing]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingRequest $request, Listing $listing)
    {
        //                     from ListingPolicy
        try {
            $this->authorize('update', $listing);
        } catch (AuthorizationException $e) {
            abort(403, 'You are not authorized to update this listing.');
        }
        $listing->update($request->validated());
        return redirect()->route('listing.index')
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
}