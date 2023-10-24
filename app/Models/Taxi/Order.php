<?php

namespace App\Models\Taxi;

use App\Models\Rating;
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
    const STATUS_MENUNGGU_PEMBAYARAN_SELESAI = 'Pembayaran Telah Berhasil!';
    const STATUS_AKTID = 'Aktif';
    const STATUS_TIMEOUT = 'Timeout';
    const STATUS_BATAL = 'Batal';
    const STATUS_SUCCESS = 'selesai';
    const STATUS_BEROPERASI = 'Terima';

    const TYPE_CHARTER = 'Charter';
    const TYPE_BOOKING = 'Booking';

    public function getStatusBadgeAttribute()
    { {
            $badges = [
                $this::STATUS_BATAL => 'danger',
                $this::STATUS_TIMEOUT => 'danger',
                $this::STATUS_AKTID => 'primary',
                $this::STATUS_MENUNGGU_PEMBAYARAN => 'warning',
                $this::STATUS_MENUNGGU_PEMBAYARAN_SELESAI => 'primary',
                $this::STATUS_SUCCESS => 'success',
                $this::STATUS_BEROPERASI => 'secondary',
            ];

            return $badges[$this->status];
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(UserDriver::class, 'user_driver_id', 'id');
    }
    public function rating()
    {
        return $this->belongsTo(Rating::class, 'ratings_id', 'id');
    }
}
