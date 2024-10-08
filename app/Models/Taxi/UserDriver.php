<?php

namespace App\Models\Taxi;

use App\Models\Rating;
use App\Models\User;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserDriver extends Model
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
    const STATUS_TRUE = 1;
    const STATUS_FALSE = 0;
    const STATUS_B = 2;

    public function getStatusBadgeAttribute()
    {
        $badges = [
            $this::STATUS_TRUE => 'success',
            $this::STATUS_FALSE => 'danger',
            $this::STATUS_B => 'dark',
        ];

        return $badges[$this->aktif];
    }
    public function getStatusAttribute()
    {
        $badges = [
            $this::STATUS_TRUE => 'Aktif',
            $this::STATUS_FALSE => 'NoAktif',
            $this::STATUS_B => 'Sedang Beroperasi',
        ];
        return $badges[$this->aktif];
    }

    protected $appends = [
        'avatar_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'user_driver_id');
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->fotokend && Storage::disk('avatars')->exists($this->fotokend)) {
            return Storage::disk('avatars')->url($this->fotokend);
        }

        return asset('noimage.png');
    }
    public function averageRating()
    {
        return Rating::where('user_driver_id', $this->id)->avg('rating');
      
    }
}
