<?php


namespace App\Http\Controllers\Resident;
use App\Http\Controllers\Resident\FacilityController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DateTime;
Use App\http\Controllers\Controller;
use App\Models\Facilities; // Import the Facilities model
use App\Models\Bookings; // Import the Bookings model
use App\Models\User; // Import the Users model
use App\Models\RefFacilitiesStatus;


class FacilityController extends Controller
{
    public function index()
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
        $facilities = Facilities::all();

        return view('resident_modules/facilities/index', compact('user_details', 'facilities'));

    }

    public function list()
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

        // Fetch facilities with their status names
        $facilities = Facilities::with('status')->get();
        return view('resident_modules.facilities.list', compact('user_details','facilities'));
    }

    public function show($id)
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

        $facility = Facilities::findOrFail($id);
        return view('resident_modules.facilities.show', compact('user_details','facility'));
    }


    public function getBookings($id)
    {
        $bookings = Bookings::where('facility_id', $id)->get(['start_datetime', 'end_datetime']);
        return response()->json($bookings);
    }

    public function book(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'event_type' => 'required|string|max:255',
            'attendees' => 'required|integer',
            'requirements' => 'nullable|string',
        ]);
    
        $startDateTime = Carbon::parse($request->date . ' ' . $request->start_time);
        $endDateTime = Carbon::parse($request->date . ' ' . $request->end_time);
    
        $existingBooking = Bookings::where('facility_id', $id)
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_datetime', [$startDateTime, $endDateTime])
                    ->orWhereBetween('end_datetime', [$startDateTime, $endDateTime])
                    ->orWhere(function ($query) use ($startDateTime, $endDateTime) {
                        $query->where('start_datetime', '<', $startDateTime)
                            ->where('end_datetime', '>', $endDateTime);
                    });
            })
            ->exists();
    
        if ($existingBooking) {
            return response()->json(['error' => 'This time slot is already booked.'], 422);
        }
    
        $booking = Bookings::create([
            'user_id' => auth()->id(),
            'facility_id' => $id,
            'booking_status' => 2,
            'event_type' => $request->event_type,
            'attendees' => $request->attendees,
            'special_requirements' => $request->requirements,
            'start_datetime' => $startDateTime,
            'end_datetime' => $endDateTime,
        ]);
    
        return response()->json([
            'success' => 'Booking request submitted successfully.',
            'date' => $booking->start_datetime->format('Y-m-d'),
            'start_time' => $booking->start_datetime->format('H:i'),
            'end_time' => $booking->end_datetime->format('H:i'),
            'event_type' => $booking->event_type,
            'attendees' => $booking->attendees,
            'requirements' => $booking->special_requirements,
        ]);
    }
          
}
