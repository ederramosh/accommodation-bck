<?php
namespace App\Controllers;

use App\Models\User;
use App\Helpers\Response;

class AuthController
{
    public function register(): void
    {
        $input = json_decode(file_get_contents('php://input'), true) ?: [];

        if (empty($input['name']) || empty($input['email']) || empty($input['password'])) {
            Response::json(['error' => 'Campos requeridos: name, email, password'], 422);
        }

        // Simple uniqueness check
        if (User::where('email', $input['email'])->exists()) {
            Response::json(['error' => 'Email ya registrado'], 409);
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            // tal como solicitaste, contraseña sin hash en primer borrador
            'password' => $input['password'],
            'rol' => $input['rol'] ?? 'user'
        ]);

        $_SESSION['user_id'] = $user->id;

        Response::json(['message' => 'Usuario registrado', 'user' => $user], 201);
    }

    public function login(): void
    {
        $input = json_decode(file_get_contents('php://input'), true) ?: [];

        if (empty($input['email']) || empty($input['password'])) {
            Response::json(['error' => 'Campos requeridos: email, password'], 422);
        }

        $user = User::where('email', $input['email'])->first();

        if (!$user || $user->password !== $input['password']) {
            Response::json(['error' => 'Credenciales inválidas'], 401);
        }

        $_SESSION['user_id'] = $user->id;
        Response::json(['message' => 'Inicio de sesión exitoso', 'user' => $user]);
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        Response::json(['message' => 'Sesión cerrada']);
    }

    public static function user(): ?User
    {
        if (!empty($_SESSION['user_id'])) {
            return User::find($_SESSION['user_id']);
        }
        return null;
    }
}
