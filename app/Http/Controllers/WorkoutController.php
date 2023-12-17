<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\Workout;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'exercise_id' => 'required|exists:exercises,id',
                'repetitions' => 'required|integer',
                'weight' => 'required|numeric',
                'break_time' => 'required|integer',
                'day' => 'required|in:SEGUNDA,TERÇA,QUARTA,QUINTA,SEXTA,SÁBADO,DOMINGO',
                'observations' => 'nullable|string',
                'time' => 'required|integer',
            ]);

            $studentId = $request->input('student_id');

            $student = Student::find($studentId);
            if (!$student) {
                return response()->json(
                    ['message' => 'Estudante não encontrado'],
                    Response::HTTP_NOT_FOUND //404
                );
            }

            $exercise = Exercise::find($request->input('exercise_id'));
            if (!$exercise) {
                return response()->json(
                    ['message' => 'Exercício não encontrado'],
                    Response::HTTP_NOT_FOUND //404
                );
            }

            $workout = new Workout($request->all());

            $workout->student()->associate($student);
            $workout->exercise()->associate($exercise);

            $workout->save();

            return response()->json($workout, Response::HTTP_CREATED); //201

        } catch (\Exception $exception) {
            return response()->json(
                ['message' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST //400
            );
        }
    }
}
