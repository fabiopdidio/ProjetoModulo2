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

    public function index(Request $request)
    {
        $user = Auth::user();

        // Lista de exercícios do usuário ordenada pela descrição
        $exercises = Exercise::where('user_id', $user->id)
            ->orderBy('description')
            ->select('id', 'description')
            ->get();

        return response()->json([
            'exercises' => $exercises,
        ], Response::HTTP_OK); // 200
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = Auth::user();

            // Verificar se o exercício existe
            $exercise = Exercise::find($id);

            if (!$exercise) {
                return response()->json(['message' => 'Exercício não encontrado', 'status' => 404],
                Response::HTTP_NOT_FOUND); //404 Não existe
            }

            // Verificar se o exercício pertence ao usuário autenticado
            if ($exercise->user_id !== $user->id) {
                return response()->json(['message' => 'Permissão negada', 'status' => 403],
                Response::HTTP_FORBIDDEN); //403 Criado por outro usuario
            }

            // Verificar se há treinos vinculados ao exercício
            if ($exercise->wourkouts()->exists()) {
                return response()->json(['message' => 'Não permitido deletar, há treinos vinculados ao exercício', 'status' => 409],
                Response::HTTP_CONFLICT); //409 conflito
            }

            // Deletar o exercício
            $exercise->delete();

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'status' => 400],
            Response::HTTP_BAD_REQUEST);
        }
    }
}
