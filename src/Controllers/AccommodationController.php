<?php
namespace App\Controllers;

use App\Models\Accommodation;
use App\Helpers\Response;

class AccommodationController
{
    public function list(): void
    {
        $accommodations = Accommodation::all();
        Response::json($accommodations);
    }

    public function create(): void
    {
        $currentUser = AuthController::user();
        if (!$currentUser || $currentUser->rol !== 'admin') {
            Response::json(['error' => 'No autorizado. Solo admin puede crear.'], 403);
        }

        $input = json_decode(file_get_contents('php://input'), true) ?: [];

        $required = ['name','address','price'];
        foreach ($required as $r) {
            if (empty($input[$r])) {
                Response::json(['error' => "Campo requerido: $r"], 422);
            }
        }

        $acc = Accommodation::create([
            'name' => $input['name'],
            'address' => $input['address'],
            'price' => $input['price'],
            'description' => $input['description'] ?? null,
            'available' => $input['available'] ?? true,
            'imageUrl' => $input['imageUrl'] ?? null
        ]);

        Response::json(['message' => 'Alojamiento creado', 'accommodation' => $acc], 201);
    }
}
