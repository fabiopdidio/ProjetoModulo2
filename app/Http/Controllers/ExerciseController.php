<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'description' => 'string|required|max:255',
            ]);

            // Verifica se o exercício já existe para o usuário
            $existingExercise = Exercise::where('user_id', auth()->id())
                ->where('description', $request->input('description'))->first();

            if ($existingExercise) {
                return $this->error('Exercício já cadastrado para o mesmo usuário', Response::HTTP_CONFLICT); //409
            }

            // Obtém o usuário autenticado
            $user = auth()->user();

            // Cria o exercício para o usuário
            $exercise = Exercise::create([
                'description' => $request->input('description'),
                'user_id' => $user->id,
            ]);

            return $this->response('Exercício criado com sucesso', Response::HTTP_CREATED, [ //201
                'exercise' => $exercise,
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST); //400
        }
    }
}
