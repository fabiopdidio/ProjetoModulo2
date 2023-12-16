<?php

namespace App\Http\Middleware;

use App\Models\Student;
use App\Models\User;
use Closure;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateStudentsLimitToUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find($request->user()->id);

        $userPlan = $user->plan_id;

        if ($userPlan === 1) {
            $limit = 10; // Bronze
        } elseif ($userPlan === 2) {
            $limit = 20; // Prata
        } else {
            $limit = PHP_INT_MAX; // Ouro (ilimitado)
        }

        $count = Student::where('user_id', $user->id)->count();

        if ($count >= $limit) {
            return response()->json(['error' => 'O usuário atingiu o limite de alunos'],
            Response::HTTP_FORBIDDEN); //403
        }

        return $next($request);
    }
}
