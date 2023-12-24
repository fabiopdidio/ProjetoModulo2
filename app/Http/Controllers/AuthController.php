<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use HttpResponses;

    public function store(Request $request)
    {
        try {
            $data = $request->only('email', 'password');

            $request->validate([
                'email' => 'string|required',
                'password' => 'string|required'
            ]);

            $authenticated = Auth::attempt($data);

            if (!$authenticated) {
                return $this->error('Não autorizado. Credenciais incorretas', Response::HTTP_UNAUTHORIZED); //401
            }

            $user = $request->user(); // Busca autenticado

            $user->tokens()->delete(); // Deleta tokens existentes

            $token = $user->createToken('simple'); // Cria novo token

            return response()->json([
                'token' => $token->plainTextToken,
                'user_name' => $user->name ?? null,
            ], Response::HTTP_OK); //201

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST); //400
        }
    }
}
