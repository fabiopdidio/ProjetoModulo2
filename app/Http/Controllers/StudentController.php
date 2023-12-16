<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:students|max:255',
                'date_birth' => 'required|date',
                'cpf' => 'required|unique:students|max:255',
                'cep' => 'nullable|string',
                'street' => 'nullable|string',
                'state' => 'nullable|string',
                'neighborhood' => 'nullable|string',
                'city' => 'nullable|string',
                'number' => 'nullable|string',
                'contact' => 'required|max:20|unique:students',
            ]);

            $student = Student::create($data);
            return response()->json($student, HttpFoundationResponse::HTTP_CREATED); // 201

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception
                ->getMessage()], HttpFoundationResponse::HTTP_BAD_REQUEST); //400
        }
    }
}
