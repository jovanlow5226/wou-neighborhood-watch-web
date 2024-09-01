<?php


namespace App\Http\Controllers\Management;
use App\Http\Controllers\Management\FacilityManagementController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Facilities; // Import the Facilities model
use App\Models\Bookings; // Import the Bookings model
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
Use App\http\Controllers\Controller;

class FacilityManagementController extends Controller
{
    public function facilityOverview()
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
        return view('management_modules/facilityOverview', compact('user_details'));

    }

    public function getFacilityDataByFacilityId(Request $request){
        // Retrieve the facility ID from the request
        $facilityId = $request->input('facility_id');

        // Fetch the facility data from the database based on the ID
        $facility = Facility::find($facilityId);

        // Check if the facility exists
        if (!$facility) {
            // Handle the case where the facility does not exist
            return response()->json(['error' => 'Facility not found'], 404);
        }

       // Return a JSON response with the facility data
       return response()->json($facility);
    }
}
