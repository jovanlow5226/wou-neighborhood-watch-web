<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function generate(Request $request)
    {
        // Check if form is submitted and generate hashed password
        if ($request->isMethod('post')) {
            $request->validate([
                'password' => 'required|string|min:2',
            ]);

            $inputPassword = $request->input('password');
            $hashedPassword = Hash::make($inputPassword);

            return view('generate_password', ['hashedPassword' => $hashedPassword]);
        }

        // Display the form
        return view('generate_password');
    }
}
