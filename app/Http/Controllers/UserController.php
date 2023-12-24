<?php

namespace App\Http\Controllers;

use App\Mail\SendWelcomeEmailToUser;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Exercise;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $request->validate([
                'name' => 'string|required|max:255',
                'email' => 'email|required|unique:users|max:255',
                'date_birth' => 'date_format:Y-m-d|required',
                'cpf' => 'string|required|unique:users|max:14',
                'password' => 'string|required|min:8|max:32',
                'plan_id' => 'required|exists:plans,id',
            ]);

            $plan = Plan::find($data['plan_id']);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'date_birth' => $data['date_birth'],
                'cpf' => $data['cpf'],
                'password' => $data['password'],
                'plan_id' => $data['plan_id'],

            ]);

            Mail::to($data['email'])
                ->send(new SendWelcomeEmailToUser($data['name'], $plan->limit, $plan->description)); // Envia email

            return response()->json($user->makeHidden(['password', 'remember_token']), Response::HTTP_CREATED); //201
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST); //400
        }
    }
}
