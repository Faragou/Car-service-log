<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'car_id',
        'type',
        'registered',
        'ownbrand',
        'accident'
    ];

    protected $casts = [
        'registered' => 'datetime',
        'ownbrand' => 'boolean'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'car_id');
    }

    public function latestService()
    {
        return $this->hasOne(Service::class, 'car_id')->latestOfMany();
    }
}
