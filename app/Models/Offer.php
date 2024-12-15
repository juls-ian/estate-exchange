<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'accepted_at', 'rejected_at'];

    // Relationship to Listing
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
    // Relationship to User 
    public function bidder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bidder_id');
    }
    // Local scope to get offer of current user 
    public function scopeByMe(Builder $query)
    {
        return $query->where('bidder_id', Auth::user()?->id);
    }
    // Local scope to exempt accepted offer
    public function scopeExcept(Builder $query, Offer $offer)
    {
        return $query->where('id', '!=', $offer->id);
    }

}