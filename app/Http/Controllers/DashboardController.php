<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user(); //Rota privada, exige autenticação

        $registeredStudents = $user->students->count();
        $registeredExercises = Exercise::where('user_id', $user->id)->count();
        $currentUserPlan = $user->plan ? $user->plan->description : null;
        $remainingStudents = $user->plan->limit - $registeredStudents;

        $data = [
            'registered_students' => $registeredStudents,
            'registered_exercises' => $registeredExercises,
            'current_user_plan' => $currentUserPlan,
            'remaining_students' => $remainingStudents,
        ];

        return $data;
    }
}
