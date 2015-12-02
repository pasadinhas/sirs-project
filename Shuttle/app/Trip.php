<?php

namespace Shuttle;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['shuttle_id', 'driver_id', 'origin', 'destination', 'leaves_at', 'arrives_at'];

    protected $dates = ['created_at', 'updated_at', 'leaves_at', 'arrives_at'];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function shuttle()
    {
        return $this->belongsTo(Shuttle::class);
    }

    public function passengers()
    {
        return $this->belongsToMany(User::class, 'bookings')->withTimestamps();
    }

    public function scopeFuture($query)
    {
        return $query->where('leaves_at', '>=', new Carbon());
    }
}
