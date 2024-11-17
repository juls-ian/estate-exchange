<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    /**
     * Show form
     */
    public function create(Listing $listing)
    {
        $listing->load(['images']); #load relationship 
        return inertia(
            'Realtor/CreateListingImage',
            ['listing' => $listing]
        );
    }

    /**
     * Store the image
     */
    public function store(Listing $listing, ImageUploadRequest $request)
    {
        if ($request->hasFile('images')) {
            $request->validated();
            # return all uploaded files        return instance of class called uploaded file
            foreach ($request->file('images') as $file) {
                #                   folder      disk (root directory)
                $path = $file->store('images', 'public');

                #store db model 
                $listing->images()->save(new ListingImage([
                    #column name
                    'filename' => $path
                ]));
            }
        }
        return redirect()->back()->with('success', 'Images uploaded');
    }

    public function destroy(Listing $listing, ListingImage $image)
    {
        # facade to access disk | delete from storage
        Storage::disk('public')->delete($image->filename);
        $image->delete(); # remove from db

        return redirect()->back()->with('success', 'Image was deleted');

    }


}