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

    public function show($id){
        try {
            // retrieve the student by ID from the database
            $student = Student::find($id);

            if (!$student){
                return response()->json(['error' => 'Student not found'], 404);
            }

            // return the student as a JSON object
            return response()->json($student, 200);

        }catch (\Exception $e){
            // if an exception occurs, return an error response
            return response()->json(['error' => 'Failed to fetch student: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        try {
            // retrieve student to delete with that ID
            $student = Student::find($id);
            // check if that student exists
            if(!$student){
                return response()->json(['error' => 'Student with that ID does not exist'], 404);
            }
            // delete the student
            $student->delete();
            // return the response
            return response()->json(['message' => 'Student deleted successfully'], 200);

        } catch (\Exception $e){
            return response()->json(['error' => 'Failed to delete student: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id){
        try {
            // retrieve the student corresponding to the id
            $student = Student::find($id);

            // check if the student exists
            if(!$student){
                return response()->json(['error' => 'A student with that ID does not exist'], 404);
            }

            // validate the request data
            $request->validate([
                'full_name' => 'required|string|max:50',
                'email' => 'required|email|unique:students,email,'.$id,
                'course' => 'required|string|max:255',
                'college' => 'required|string|max:255',
                'birth_date' => 'required|date',
            ]);

            // update the student details
            $student->update([
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'course' => $request->input('course'),
                'college' => $request->input('college'),
                'birth_date' => $request->input('birth_date')
            ]);

            // send a response after updating the student details
            return response()->json(['message' => 'Student details updated properly'], 200);

        } catch (\Exception $e){
            return response()->json(['error' => 'Failed to update student details: ' . $e->getMessage()], 500);
        }
    }
}
