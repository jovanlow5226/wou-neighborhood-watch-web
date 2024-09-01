<?php

namespace App\Http\Controllers\Management;
use App\Http\Controllers\Management\RegistrationController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
Use App\http\Controllers\Controller;

class RegistrationController extends Controller
{
    public function showRegisterPage()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Store User Details
        // Create an array with user details
        $user_details = [
            'login_id' => $user->login_id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        // Pass the user details to the view
        return view('management_modules/register_page', compact('user_details'));

    }

    public function register(Request $request){
        // Validate the incoming request data
        $validatedData = $request->validate([
            'user_type' => 'required',
            'login_id' => 'required|unique:users',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        try {
            // Create a new User instance
            $user = new User();
            $user->user_type = $validatedData['user_type'];
            $user->login_id = $validatedData['login_id'];
            $user->name = $validatedData['username'];
            $user->password = Hash::make($validatedData['password']);
            $user->email = $validatedData['email'];
            $user->created_at = \Carbon\Carbon::now();
    
            // Save the user to the database
            $user->save();
    
            // return success message
            return redirect()->route('register.page')->with('success', 'User registered successfully');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors)
            // Flash the error message to the session and redirect back with the input data
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while registering the user.']);
        }
    }
}
