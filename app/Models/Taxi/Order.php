<?php

namespace App\Models\Taxi;

use App\Models\User;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
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

    const STATUS_MENUNGGU_PEMBAYARAN = 'Menunggu Pembayaran';
    const STATUS_AKTID = 'Aktif';
    const STATUS_SUCCESS = 'selesai';
    const STATUS_BEROPERASI = 'Sedang Beroperasi';

    const TYPE_CHARTER = 'Charter';
    const TYPE_BOOKING = 'Booking';

    public function getStatusBadgeAttribute()
    {
        $badges = [
            $this::STATUS_AKTID => 'primary',
            $this::STATUS_MENUNGGU_PEMBAYARAN => 'warning',
            $this::STATUS_SUCCESS => 'success',
            $this::STATUS_BEROPERASI => 'secondary',
        ];

        return $badges[$this->status];
    }
    public function getStatusBadgeBookingAttribute()
    {
        $badges = [
            $this::STATUS_MENUNGGU_PEMBAYARAN => 'warning',
            $this::STATUS_AKTID => 'primary',
            $this::STATUS_SUCCESS => 'success',
            $this::STATUS_BEROPERASI => 'secondary',
        ];

        return $badges[$this->status];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(UserDriver::class, 'user_driver_id', 'id');
    }
}
