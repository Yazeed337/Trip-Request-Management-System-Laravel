<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TripRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destination_id',
        'travel_date',
        'duration_days',
        'travelers_count',
        'notes',
        'status',
        'estimated_cost'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        // Generate unique request number if not set
        if (empty($model->request_number)) {
            $model->request_number = static::generateUniqueRequestNumber();
        }
    });
}

protected static function generateUniqueRequestNumber()
{
    $prefix = 'TR-' . date('Ymd') . '-';
    $maxAttempts = 10;
    $attempt = 0;

    do {
        $code = $prefix . Str::upper(Str::random(4));
        $attempt++;
    } while ($attempt < $maxAttempts && static::where('request_number', $code)->exists());

    return $code;
}
}