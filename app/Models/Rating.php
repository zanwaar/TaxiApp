<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    use Uuid;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $guarded = [];

    public static function averageRatingByDriver($userDriverId)
    {
        $totalRatings = static::where('user_driver_id', $userDriverId)->count();
        $totalPoints = static::where('user_driver_id', $userDriverId)->sum('rating');

        if ($totalRatings > 0) {
            return round($totalPoints / $totalRatings, 1);
        } else {
            return 0;
        }
    }
}
