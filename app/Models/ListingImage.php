<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingImage extends Model
{
    use HasFactory;
    # ATTRIBUTES = COLUMN NAME
    protected $fillable = ['filename'];
    # custom attribute 
    protected $appends = ['src'];  #append to list of this model 

    # RELATIONSHIP TO THE LISTING 
    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    // Generate url of uploaded images
    //  getRealSrcAttribute -> real_src
    public function getSrcAttribute()
    {
        // produce url relative to the folder using the filename
        return asset("storage/{$this->filename}");
    }
}