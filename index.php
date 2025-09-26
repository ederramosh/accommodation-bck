<?php
// public/index.php
require __DIR__ . '/../bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\AccommodationController;
use App\Controllers\BookingController;
use App\Helpers\Response;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Rutas limpias (ejemplos)
if ($uri === '/' && $method === 'GET') {
    // landing -> lista alojamientos
    (new AccommodationController())->list();
}

// AUTH
if ($uri === '/register' && $method === 'POST') {
    (new AuthController())->register();
}

if ($uri === '/login' && $method === 'POST') {
    (new AuthController())->login();
}

if ($uri === '/logout' && $method === 'POST') {
    (new AuthController())->logout();
}

// ACCOUNT - vista del usuario (reservas)
if ($uri === '/account' && $method === 'GET') {
    (new BookingController())->listUserBookings();
}

// BOOKING
if ($uri === '/book' && $method === 'POST') {
    (new BookingController())->create();
}

// DELETE booking: /book/{id} with DELETE
if (preg_match('#^/book/(\d+)$#', $uri, $m) && $method === 'DELETE') {
    $id = (int)$m[1];
    (new BookingController())->delete($id);
}

// ACCOMMODATION create (admin)
if ($uri === '/accommodation' && $method === 'POST') {
    (new AccommodationController())->create();
}

// otherwise: 404
Response::json(['error' => 'Ruta no encontrada'], 404);
