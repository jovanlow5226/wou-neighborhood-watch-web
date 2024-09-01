<?php


namespace App\Http\Controllers\Management;
use App\Http\Controllers\Management\BookingManagementController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DateTime;
Use App\http\Controllers\Controller;
use App\Models\Facilities; // Import the Facilities model
use App\Models\Bookings; // Import the Bookings model
use App\Models\User; // Import the Users model


class BookingManagementController extends Controller
{
    public function bookingOverview()
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

         // Retrieve bookings based on booking status criteria (2 for pending approval, 3 for approved, and 4 for rejected)
        $newRequests = Bookings::with('facilities','user')->where('booking_status', 2)->paginate(3);
        $approvedRequests = Bookings::with('facilities','user')->where('booking_status', 3)->paginate(3);
        $rejectedRequests = Bookings::with('facilities','user')->where('booking_status', 4)->paginate(3);

        // Pass the user details to the view
        return view('management_modules/bookingOverview', compact('user_details', 'newRequests', 'approvedRequests', 'rejectedRequests'));

    }

    public function getBookingDataByBookingId(Request $request){
        // Retrieve the booking ID from the request
        $bookingId = $request->input('booking_id');
    
        // Fetch the booking data from the database based on the ID
        $booking = Bookings::with('facilities','refBookingStatuses')->find($bookingId);
    
        // Check if the booking exists
        if (!$booking) {
            // Handle the case where the booking does not exist
            return response()->json(['error' => 'Booking not found'], 404);
        }
    
        // Retrieve facility ID, start datetime, and end datetime from the booking
        $facilityId = $booking->facility_id;
        $startDatetime = $booking->start_datetime;
        $endDatetime = $booking->end_datetime;
    
        // Fetch the facility's capacity from the database
        $facility = Facilities::find($facilityId);
    
        // Check if the facility exists
        if (!$facility) {
            // Handle the case where the facility does not exist
            return response()->json(['error' => 'Facility not found'], 404);
        }
    
        // Calculate the total capacity of the facility
        $totalCapacity = $facility->capacity;
    
        // Get the current booking's created_at timestamp
        $currentBookingCreatedAt = Bookings::find($bookingId)->created_at;
    
        // Query the database to check for overlapping bookings
        $overlappingBookings = Bookings::where('facility_id', $facilityId)
            ->where(function ($query) use ($startDatetime, $endDatetime, $bookingId) {
                $query->where(function ($q) use ($startDatetime, $endDatetime) {
                    $q->where('start_datetime', '>=', $startDatetime)
                        ->where('start_datetime', '<', $endDatetime);
                })
                ->orWhere(function ($q) use ($startDatetime, $endDatetime) {
                    $q->where('end_datetime', '>', $startDatetime)
                        ->where('end_datetime', '<=', $endDatetime);
                });
            })
            ->whereIn('booking_status', [2, 3]) // Check for booking_status IN (2, 3)
            ->where('id', '!=', $bookingId)
            ->orderBy('created_at') // Order by created_at to get the earliest booking first
            ->select('id', 'created_at') // Select only the id and created_at columns
            ->get();
    
        // Initialize array to store colliding booking IDs with their created_at timestamps
        $collidingBookingIds = [];
    
        // Check if the current booking's created_at timestamp is the earliest
        $isCurrentBookingEarliest = true;
        foreach ($overlappingBookings as $bookings) {
            if ($bookings->created_at < $currentBookingCreatedAt) {
                // If any overlapping booking has an earlier created_at timestamp, set flag to false, store its id and created_at
                $isCurrentBookingEarliest = false;
                $created_at = $bookings->created_at;
                $collidingBookingIds[] = [
                    'id' => $bookings->id,
                    'created_at' => (new DateTime($bookings->created_at))->format('Y-m-d H:i:s')
                ];
                break;
            }
        }
    
        // Return the details of the current booking along with the IDs and created_at of colliding bookings
        return response()->json([
            'current_booking' => $booking,
            'colliding_bookings' => $collidingBookingIds
        ]);
    }
          
}
