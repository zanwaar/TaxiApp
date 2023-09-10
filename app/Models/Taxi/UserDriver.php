<?php

namespace App\Models\Taxi;

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getStatusBadgeAttribute()
    {
        $badges = [
            $this::STATUS_TRUE => 'success',
            $this::STATUS_FALSE => 'danger',
        ];

        return $badges[$this->aktif];
    }
    public function getStatusAttribute()
    {
        $badges = [
            $this::STATUS_TRUE => 'Aktif',
            $this::STATUS_FALSE => 'NoAktif',
        ];

        return $badges[$this->aktif];
    }
    protected $appends = [
        'avatar_url',
    ];

    public function getAvatarUrlAttribute()
    {
        if ($this->fotokend && Storage::disk('avatars')->exists($this->fotokend)) {
            return Storage::disk('avatars')->url($this->fotokend);
        }

        return asset('noimage.png');
    }
}
