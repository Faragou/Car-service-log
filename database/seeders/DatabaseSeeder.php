<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Car;
use App\Models\Service;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        if (Client::count() == 0 && Car::count() == 0 && Service::count() == 0) {
            $this->call(JSONDataSeeder::class);
        }
    }
}
