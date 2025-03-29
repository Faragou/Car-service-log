<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedDatabase extends Command
{
    protected $signature = 'db:seed_database';
    protected $description = 'Check if tables are empty and seed from JSON if empty';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Checking if tables are empty...');

        if (DB::table('clients')->count() == 0) {
            $this->info('Clients table is empty. Seeding data...');
            $clientsData = json_decode(file_get_contents(database_path('data/clients.json')), true);
            DB::table('clients')->insert($clientsData);
        }

        if (DB::table('services')->count() == 0) {
            $this->info('Services table is empty. Seeding data...');
            $servicesData = json_decode(file_get_contents(database_path('data/services.json')), true);
            DB::table('services')->insert($servicesData);
        }

        if (DB::table('cars')->count() == 0) {
            $this->info('Cars table is empty. Seeding data...');
            $carsData = json_decode(file_get_contents(database_path('data/cars.json')), true);
            DB::table('cars')->insert($carsData);
        }

        $this->info('Database seeding complete!');
    }
}

