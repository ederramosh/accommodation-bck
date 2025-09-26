<?php
namespace App\Controllers;

use App\Models\Book;
use App\Models\Accommodation;
use App\Helpers\Response;

class BookingController
{
    public function create(): void
    {
        $user = AuthController::user();
        if (!$user) {
            Response::json(['error' => 'No autenticado'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true) ?: [];
        if (empty($input['id_accommodation'])) {
            Response::json(['error' => 'Campo requerido: id_accommodation'], 422);
        }

        $acc = Accommodation::find($input['id_accommodation']);
        if (!$acc) {
            Response::json(['error' => 'Alojamiento no encontrado'], 404);
        }

        $book = Book::create([
            'id_user' => $user->id,
            'id_accommodation' => $acc->id,
            'reservation' => true,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Response::json(['message' => 'Reserva creada', 'book' => $book], 201);
    }

    public function listUserBookings(): void
    {
        $user = AuthController::user();
        if (!$user) {
            Response::json(['error' => 'No autenticado'], 401);
        }

        $books = $user->books()->with('accommodation')->get();
        Response::json($books);
    }

    public function delete(int $bookId): void
    {
        $user = AuthController::user();
        if (!$user) {
            Response::json(['error' => 'No autenticado'], 401);
        }

        $book = Book::find($bookId);
        if (!$book) {
            Response::json(['error' => 'Reserva no encontrada'], 404);
        }
        if ($book->id_user !== $user->id) {
            Response::json(['error' => 'No autorizado para eliminar esta reserva'], 403);
        }

        $book->delete();
        Response::json(['message' => 'Reserva eliminada']);
    }
}
