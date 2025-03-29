<?php

// app/Http/Controllers/ClientController.php

namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Service;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        // Visszaadja az összes kliens adatot
        $clients = Client::all();
        return response()->json($clients);
    }

    public function getCars($id)
    {
        try {
            // Ellenőrizzük, hogy az ügyfél létezik-e
            $client = Client::findOrFail($id);

            // Lekérjük az ügyfél autóit
            $cars = Car::where('client_id', $id)->get();

            return response()->json($cars, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hiba történt az ügyfél autóinak lekérése közben.'], 500);
        }
    }
    public function searchClient(Request $request)
    {
        // Validáció
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'document_id' => 'nullable|alpha_num|max:255',
        ]);

        if (!$validated['name'] && !$validated['document_id']) {
            return response()->json(['error' => 'A kereséshez legalább az egyik mezőt ki kell tölteni!'], 400);
        }

        if ($validated['name'] && $validated['document_id']) {
            return response()->json(['error' => 'Csak az egyik mező tölthető ki!'], 400);
        }

        $query = Client::query();

        if ($validated['name']) {
            $clients = $query->where('name', 'like', '%'.$validated['name'].'%')->get();

            // Ha több mint egy találat van, hibát dobunk
            if ($clients->count() > 1) {
                // Frontend-en ezt kezelhetjük a toast üzenettel
                return response()->json([
                    'clients' => $clients,
                    'message' => 'Túl sok találat, kérjük pontosítson!'
                ]);
            }

            // Ha nincs találat, üres választ adunk
            if ($clients->isEmpty()) {
                return response()->json([]);
            }

            $client = $clients->first();
        }

        // Kártyanév (okmányazonosító) keresése
        if ($validated['document_id']) {
            $client = Client::where('card_name', $validated['document_id'])->first();

            // Ha nincs találat, üres választ adunk
            if (!$client) {
                return response()->json([]);
            }
        }

        $clients = $query->get();

        if($clients->isEmpty()) {
            return response()->json([]);
        }

        $client = $clients->first();

        // Kliens adatainak visszaadása
        $clientData = [
            'id' => $client->id,
            'name' => $client->name,
            'document_id' => $client->card_name, // Itt a card_name oszlopot kell használni, nem document_id
            'cars_count' => Car::where('client_id', $client->id)->count(),
            'service_records_count' => Service::where('client_id', $client->id)->count(),
        ];


        // Ha találat van, visszaadjuk őket
        return response()->json([$clientData]);
    }



}
