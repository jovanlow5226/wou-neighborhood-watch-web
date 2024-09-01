<?php 
namespace App\Http\Controllers\Resident;
use App\Http\Controllers\Resident\BookingController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DateTime;
Use App\http\Controllers\Controller;
use App\Models\Facilities;
use App\Models\Bookings;
use App\Models\User;

class BookingController extends Controller
{
    public function history()
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

        $user_id = auth()->id();

        // Fetch upcoming bookings
        $upcomingBookings = Bookings::with('facilities')
                                        ->with('refBookingStatuses')
                                        ->where('user_id', $user_id)
                                        ->where('start_datetime', '>=', now())
                                        ->whereNotIn('booking_status', [1, 4, 5])
                                        ->orderBy('start_datetime', 'asc')
                                        ->paginate(10); 
        // Fetch past bookings
        $pastBookings = Bookings::with('facilities')
                                    ->where('user_id', $user_id)
                                    ->where('start_datetime', '<', now())
                                    ->whereNotIn('booking_status', [1, 4, 5])
                                    ->orderBy('start_datetime', 'desc')
                                    ->paginate(10); 
        // Fetch rejected bookings
        $rejectedBookings = Bookings::with('facilities')
                                        ->where('user_id', $user_id)
                                        ->where('booking_status', 4)
                                        ->orderBy('start_datetime', 'desc')
                                        ->paginate(10); 

        // Retrieve cancelled bookings
        $cancelledBookings = Bookings::with('facilities')
                                        ->where('user_id', $user_id)
                                        ->where('booking_status', 5) // Assuming 5 is the status for cancelled bookings
                                        ->orderBy('start_datetime', 'desc')
                                        ->paginate(10);

        return view('resident_modules.facilities.history', compact('user_details', 'upcomingBookings', 'pastBookings', 'rejectedBookings', 'cancelledBookings'));
    }

    public function cancel(Bookings $booking)
    {
        // Check if the user is authorized to cancel this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update the booking status to Cancelled (assuming 5 is the status for cancelled bookings)
        $booking->booking_status = 5;
        $booking->save();

        // Redirect back to the booking history page with a success message
        return redirect()->route('bookings.history')->with('success', 'Booking has been successfully cancelled.');
    }

}
