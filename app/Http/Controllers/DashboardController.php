<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    /*public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Lógica para obter a quantidade de estudantes cadastrados pelo usuário
        $registeredStudents = $user->students()->count();

        // Lógica para obter a quantidade de exercícios cadastrados pelo usuário
        $registeredExercises = ExerciseController-> $user->exercise()->count();

        // Lógica para obter o plano atual do usuário
        $currentUserPlan = $user->plan_id>description;

        // Lógica para obter a quantidade de cadastros restantes de estudantes
        $remainingStudents = $user->plan_limit - $registeredStudents;

        $data = [
            'registered_students' => $registeredStudents,
            'registered_exercises' => $registeredExercises,
            'current_user_plan' => $currentUserPlan,
            'remaining_students' => $remainingStudents,
        ];

        return response()->json([
            'message' => 'Dashboard retornado com sucesso',
            'data' => $data,
        ], Response::HTTP_OK);
    }*/
}
