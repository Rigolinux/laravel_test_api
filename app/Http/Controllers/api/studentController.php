<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class studentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        //check if there are no students
        if ($students->count() == 0) {
            return response()->json([
                'message' => 'No students found',
            ]);
        }

        return response()->json([
            'students' => $students,
        ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'language' => 'required',
        ]);

        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        try {
            $student->save();
            return response()->json([
                'message' => 'Student saved successfully',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Verificar si la excepción es debido a una violación de restricción de base de datos
            if ($e->getCode() == '23000') { // Código para restricciones de integridad
                return response()->json([
                    'message' => 'Error saving student',
                    'error' => $e->getMessage(), // Mensaje de error de la excepción
                ], 422); // Código de estado 422 indica una solicitud no procesable
            } else {
                // Otro tipo de error, puedes manejarlo según sea necesario
                return response()->json([
                    'message' => 'Error saving student',
                    'error' => $e->getMessage(), // Mensaje de error de la excepción
                ], 500); // Código de estado 500 indica un error interno del servidor
            }
        }


        return response()->json([
            'message' => 'Student created successfully',
        ]);
    }

    // find one student
    public function show(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ]);
        }

        return response()->json([
            'student' => $student,
        ]);
    }

    // update student

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'language' => 'required',
        ]);

        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ]);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        $student->save();

        return response()->json([
            'message' => 'Student updated successfully',
        ]);
    }



    // delete student
    public function destroy(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ]);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully',
        ]);
    }





}
