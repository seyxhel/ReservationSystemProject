<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Debug: Check if the student exists
        $studentExists = \App\Models\Student::where('email', $credentials['email'])->exists();
        if (!$studentExists) {
            return back()->withErrors([
                'email' => 'No account found with this email.',
            ]);
        }

        // Attempt login using 'student' guard
        if (Auth::guard('student')->attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect to student dashboard
            return redirect()->route('student.dashboard');
        }

        // If authentication fails, show an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        // Log out the student
        Auth::guard('student')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('student.login');
    }

}
