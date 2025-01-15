<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; // Make sure the Student model exists
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Show the student registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.student-register');
    }

    /**
     * Handle student registration form submission.
     */
    public function register(Request $request)
    {
        // Validate form inputs
        $validated = $request->validate([
            'email' => 'required|email|unique:students,email',
            'student_id' => 'required|regex:/^\d{4}-\d{5}-[A-Z]{2}-\d$/|unique:students,student_id',
            'year_section' => 'required|regex:/^[1-4]-[1-5]$/',
            'program' => 'required|regex:/^[A-Z]{2,10}$/',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other,prefer-not-to-say',
            'birthday' => 'required|date',
            'contact' => 'required|digits:11',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new student record in the database
        Student::create([
            'email' => $validated['email'],
            'student_id' => $validated['student_id'],
            'year_section' => $validated['year_section'],
            'program' => $validated['program'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'birthday' => $validated['birthday'],
            'contact' => $validated['contact'],
            'password' => Hash::make($validated['password']), // Hash the password
        ]);

        // Redirect the user to the login page with a success message
        return redirect()->route('student.login')->with('success', 'Account created successfully! Please log in.');
    }
}
