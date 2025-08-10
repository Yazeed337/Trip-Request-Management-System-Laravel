<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'currency',
        'exchange_rate',
        'min_daily_budget',
        'max_daily_budget',
        'image_url',
        'badge_type',
        'badge_text_ar',
        'badge_text_en',
        'is_popular',
        'best_months',
        'weather_types',
        'trip_types',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_popular' => 'boolean',
        'best_months' => 'array',
        'weather_types' => 'array',
        'trip_types' => 'array',
        'exchange_rate' => 'decimal:4',
    ];

    /**
     * Get the trip requests for the destination.
     */
    public function tripRequests()
    {
        return $this->hasMany(TripRequest::class);
    }

    /**
     * Get popular destinations.
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Get destinations within budget range.
     */
    public function scopeWithinBudget($query, $budget)
    {
        return $query->where('min_daily_budget', '<=', $budget)
                    ->where('max_daily_budget', '>=', $budget);
    }

    /**
     * Get destinations suitable for specific month.
     */
    public function scopeForMonth($query, $month)
    {
        return $query->whereJsonContains('best_months', $month);
    }

    /**
     * Get destinations suitable for specific weather preference.
     */
    public function scopeForWeather($query, $weather)
    {
        return $query->whereJsonContains('weather_types', $weather);
    }

    /**
     * Get destinations suitable for specific trip type.
     */
    public function scopeForTripType($query, $tripType)
    {
        return $query->whereJsonContains('trip_types', $tripType);
    }
}