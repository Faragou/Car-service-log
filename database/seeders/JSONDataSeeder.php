<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Car;
use App\Models\Service;

class JSONDataSeeder extends Seeder
{
    public function run()
    {
        // Seed Clients
        $clientsJson = file_get_contents(database_path('data/clients.json'));
        $clients = json_decode($clientsJson, true);
        foreach ($clients as $clientData) {
            Client::create([
                'id' => $clientData['id'],
                'name' => $clientData['name'],
                'card_name' => $clientData['idcard']
            ]);
        }

        // Seed Cars
        $carsJson = file_get_contents(database_path('data/cars.json'));
        $cars = json_decode($carsJson, true);
        foreach ($cars as $carData) {
            Car::create([
                'id' => $carData['id'],
                'client_id' => $carData['client_id'],
                'car_id' => $carData['car_id'],
                'type' => $carData['type'],
                'registered' => $carData['registered'],
                'ownbrand' => $carData['ownbrand'],
                'accident' => $carData['accident']
            ]);
        }

        // Seed Services
        $servicesJson = file_get_contents(database_path('data/services.json'));
        $services = json_decode($servicesJson, true);
        foreach ($services as $serviceData) {
            Service::create([
                'id' => $serviceData['id'],
                'client_id' => $serviceData['client_id'],
                'car_id' => $serviceData['car_id'],
                'lognumber' => $serviceData['lognumber'],
                'event' => $serviceData['event'],
                'eventtime' => $serviceData['eventtime'],
                'document_id' => $serviceData['document_id']
            ]);
        }
    }
}
