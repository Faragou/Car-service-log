<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'service_type', 'date', 'details'];

    // Kapcsolat a Client modellel
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
