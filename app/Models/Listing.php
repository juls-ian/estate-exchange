<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;
    // ATTRIBUTES = COLUMN NAME
    protected $fillable = [
        'beds',
        'baths',
        'area',
        'city',
        'code',
        'street',
        'street_num',
        'price'
    ];
    protected $sortableColumns = [
        'price',
        'created_at'
    ];

    // RELATIONSHIP TO USER
    public function owner()
    {
        return $this->belongsTo(Listing::class, 'owner_id');
    }

    // RELATIONSHIP TO LISTING IMAGE 
    public function images()
    {
        return $this->hasMany(ListingImage::class);
    }

    public function scopeMostRecent(Builder $query)
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        return $query
            ->when(
                # if key is not in the array defaults to false
                $filters['priceFrom'] ?? false,
                #$query to modify, $filter from $filters triggered in when()
                fn($query, $filter) => $query->where('price', '>=', $filter)
            )->when(
                $filters['priceTo'] ?? false,
                fn($query, $filter) => $query->where('price', '<=', $filter)
            )->when(
                $filters['beds'] ?? false,                              #convert $filter to number before comparison
                fn($query, $filter) => $query->where('beds', (int) $filter < 6 ? '=' : '>=', $filter)
            )->when(
                $filters['baths'] ?? false,                              #convert $filter to number
                fn($query, $filter) => $query->where('baths', (int) $filter < 6 ? '=' : '>=', $filter)
            )->when(
                $filters['areaFrom'] ?? false,
                fn($query, $filter) => $query->where('area', '>=', $filter)
            )->when(
                $filters['areaTo'] ?? false,
                fn($query, $filter) => $query->where('area', '<=', $filter)
                #SOFT DELETE
            )->when(
                $filters['deleted'] ?? false,
                fn($query) => $query->withTrashed()#returns softly deleted
                # SORTING
            )->when(
                $filters['by'] ?? false,
                fn($query, $filter) =>
                // check the value is not in sortable
                !in_array($filter, $this->sortableColumns) ? $query :
                $query->orderBy($filter, $filters['order'] ?? 'desc')
            );
    }
}