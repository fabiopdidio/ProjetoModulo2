<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\Workout;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as FacadesView;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade\PDF as PDF;

class WorkoutController extends Controller
{
    public function store(Request $request) // Cadastro de treino
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

    public function index($studentId) // Listagem de treinos
    {
        try {
            $student = Student::find($studentId);

            if (!$student) {
                return response()->json(
                    ['message' => 'Estudante não encontrado'],
                    Response::HTTP_NOT_FOUND //404
                );
            }

            $workouts = Workout::where('student_id', $studentId)
                ->orderBy('day')
                ->get();

            $allWorkouts = $workouts->groupBy('day');

            return response()->json($allWorkouts, Response::HTTP_OK); //200

        } catch (\Exception $exception) {
            return response()->json(
                ['message' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST //400
            );
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            $studentId = $request->query('id_do_estudante');
            $student = Student::find($studentId);

            $workouts = Workout::with('exercise')
                ->where('student_id', $studentId)
                ->get();

            $pdf = PDF::loadView(
                'pdf.workout',
                ['student' => $student, 'workouts' => $workouts]
            );

            return $pdf->stream();
        } catch (\Exception $exception) {
            return response()->json(
                ['message' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST //400
            );
        }
    }
}
