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

    public function index(Request $request)
    {
        try {
            $user = $request->user();

            $query = Student::where('user_id', $user->id)
                ->where(function ($search) use ($request) {
                    $search->
                    where('name', 'like', '%' . $request->input('search') . '%') // % para pegar em qualquer lugar
                        ->orWhere('cpf', 'like', '%' . $request->input('search') . '%')
                        ->orWhere('email', 'like', '%' . $request->input('search') . '%');
                });

            $students = $query->orderBy('name')->get(); // Ordenação pelo nome

            return response()->json($students, HttpFoundationResponse::HTTP_OK); // 200

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()],
            HttpFoundationResponse::HTTP_BAD_REQUEST); // 400
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $student = Student::find($id); // Busca estudante

            if (!$student) { // Estudante existe?
                return response()->json(['message' => 'Estudante não encontrado.'],
                HttpFoundationResponse::HTTP_NOT_FOUND); // 404
            }

            if ($student->user_id !== $request->user()->id) { // Estudante não pertence ao user
                return response()->json(['message' => 'Acesso negado.'],
                HttpFoundationResponse::HTTP_FORBIDDEN); // 403
            }

            if ($student->trashed()) {
                return response()->json(['message' => 'Estudante já excluído.'],
                HttpFoundationResponse::HTTP_BAD_REQUEST); // Estudante ja excluido
            }

            $student->delete();

            return response()->json(['message' => 'Estudante excluído com sucesso.'],
            HttpFoundationResponse::HTTP_NO_CONTENT); // 204

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()],
            HttpFoundationResponse::HTTP_BAD_REQUEST); // 400
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string|max:255|nullable',
                'email' => 'string|email|max:255|unique:students,email,' . $id . '|nullable',
                'date_birth' => 'string|date|nullable',
                'cpf' => 'string|max:255|unique:students,cpf,' . $id . '|nullable',
                'cep' => 'string|nullable',
                'street' => 'string|nullable',
                'state' => 'string|nullable',
                'neighborhood' => 'string|nullable',
                'city' => 'string|nullable',
                'complement' => 'string|nullable',
                'number' => 'string|nullable',
                'contact' => 'required|string|max:20|unique:students,contact,' . $id,
            ]);

            // Busca e atualiza o estudante
            $student = Student::find($id);

            if (!$student) {
                return response()->json(['message' => 'Estudante não encontrado'],
                HttpFoundationResponse::HTTP_NOT_FOUND);
            }

            $student->update($request->all());

            return response()->json(['message' => 'Estudante atualizado com sucesso'],
            HttpFoundationResponse::HTTP_OK); // 200

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()],
            HttpFoundationResponse::HTTP_BAD_REQUEST); // 400
        }
    }


}
