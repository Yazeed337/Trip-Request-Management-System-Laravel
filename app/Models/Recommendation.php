<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'budget',
        'travel_month',
        'weather_preference',
        'trip_type',
        'recommended_destinations',
        'recommendation_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'recommended_destinations' => 'array',
    ];

    /**
     * Get the user that owns the recommendation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get recommended destinations with full details.
     */
    public function getRecommendedDestinationsFullAttribute()
    {
        if (empty($this->recommended_destinations)) {
            return collect();
        }

        return Destination::whereIn('id', $this->recommended_destinations)->get();
    }
}