<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(Request $request){
        try {
            // Validate the request data
            $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
                'course' => 'required|string|max:255',
                'college' => 'required|string|max:255',
                'birth_date' => 'required|date',
            ]);

            // Create a new Student instance
            $student = new Student();
            
            // Assign attributes from the request data
            $student->full_name = $request->input('full_name');
            $student->email = $request->input('email');
            $student->course = $request->input('course');
            $student->college = $request->input('college');
            $student->birth_date = $request->input('birth_date');

            // Save the Student instance to the database
            $student->save();

            // Return a success response
            return response()->json(['message' => 'Student created successfully'], 201);
        } catch (\Exception $e) {
            // If an exception occurs, return an error response
            return response()->json(['error' => 'Failed to create student: ' . $e->getMessage()], 500);
        }
    }


    public function index(){
        try {
            // retrieve all students from the database
            $students = Student::all();

            //  return the students as a JSON response
            return response()->json($students, 200);
            
        }catch (\Exception $e) {
            // If an exception occurs, return an error response
            return response()->json(['error' => 'Failed to fetch students: ' . $e->getMessage()], 500);
        }
    }
}
