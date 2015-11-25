<?php

namespace Shuttle;

use Illuminate\Database\Eloquent\Model;

class Shuttle extends Model
{
    protected $table = 'shuttles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'seats', 'key'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['key'];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
