<?php
// app/Models/Client.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'card_name'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'client_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'client_id');
    }

    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class); // vagy más kapcsolat típus, ha szükséges
    }

}
