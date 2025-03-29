<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Service;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // CarController.php
    public function getServiceLogs($clientId, $carIndex)
    {
        try {
            // Lekérjük az adott ügyfél összes autóját
            $cars = Car::where('client_id', $clientId)->orderBy('id')->get();

            // Megnézzük, hogy van-e ennyi autója az ügyfélnek
            if ($cars->count() < $carIndex) {
                return response()->json([
                    'error' => 'The requested car index does not exist for this client.'
                ], 404);
            }

            // Az ügyfél adott sorszámú autójának az azonosítója
            $car = $cars[$carIndex - 1]; // Mivel 1-től indul a sorszámozás, de a tömb 0-tól

            // Lekérjük az adott autóhoz tartozó service logokat
            $serviceLogs = Service::where('car_id', $car->car_id)
                ->where('client_id', $clientId)
                ->orderByDesc('eventtime')
                ->get()
                ->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'lognumber' => $service->lognumber,
                        'event_name' => $service->event,
                        'date' => $service->eventtime,
                        'work_order_id' => $service->document_id,
                        'car_id' => $service->car_id,
                        'client_id' => $service->client_id,
                    ];
                });

            // Ha nincs szerviznapló, üzenetet küldünk
            if ($serviceLogs->isEmpty()) {
                return response()->json([
                    'car' => [
                        'id' => $car->id,
                        'type' => $car->type,
                        'registered' => $car->registered,
                    ],
                    'service_logs' => [],
                    'message' => 'No service logs found for this car.'
                ]);
            }

            return response()->json([
                'car' => [
                    'id' => $car->id,
                    'type' => $car->type,
                    'registered' => $car->registered,
                ],
                'service_logs' => $serviceLogs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error fetching service logs.',
                'message' => $e->getMessage()
            ], 500);
        }
    }




}
