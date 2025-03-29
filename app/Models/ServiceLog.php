<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLog extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default
    protected $table = 'service_logs';

    // Fillable fields for mass assignment
    protected $fillable = [
        'car_id',
        'lognumber',
        'event_name',
        'date',
        'work_order_id',
        'registration_date'
    ];

    // Define relationships
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    // Accessor for formatting date
    public function getFormattedDateAttribute()
    {
        return $this->event_name === 'regisztralt'
            ? $this->registration_date
            : $this->date;
    }

    // Scope for filtering by car
    public function scopeForCar($query, $carId)
    {
        return $query->where('car_id', $carId)
            ->orderByDesc('created_at');
    }
}
