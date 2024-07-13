<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\House;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;



class BookingController extends Controller
{
    /**
     * Display the booking form.
     *
     * @param  int  $houseId
     * @return \Illuminate\View\View
     */
    public function showBookingForm($houseId)
    {
        $house = House::findOrFail($houseId);
        return view('bookings.booking', compact('house'));
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'house_id' => 'required|exists:houses,id',
            'move_in_date' => 'required|date',
            'lease_duration' => 'required|integer|min:1',
            'number_of_occupants' => 'required|integer|min:1',
            'employment_status' => 'required|string',
            'contact_method' => 'required|string',
            'message' => 'nullable|string',
        ]);
    
        // Get the authenticated user's ID
        $user_id = Auth::id();
    
        // Create a new Booking with the user_id included
        $booking = new Booking();
        $booking->user_id = $user_id;
        $booking->house_id = $request->house_id;
        $booking->move_in_date = $request->move_in_date;
        $booking->lease_duration = $request->lease_duration;
        $booking->number_of_occupants = $request->number_of_occupants;
        $booking->employment_status = $request->employment_status;
        $booking->contact_method = $request->contact_method;
        $booking->message = $request->message;
        $booking->save();
    
        // Fetch the house and lister information
        $house = House::findOrFail($request->house_id);
        $lister = User::findOrFail($house->lister_id);
    
        // Create a notification for the lister
        $notification = new Notification();
        $notification->lister_id = $lister->id;
        $notification->house_id = $house->id;
        $notification->hunter_id = $user_id;
        $notification->message = "A booking has been made for your house: " . $house->location;
        $notification->save();
    
        // Send an email to the lister with the embedded image
        Mail::send('emails.booking-information', ['house' => $house, 'booking' => $booking], function($message) use ($lister) {
            $message->to($lister->email);
            $message->subject('New Booking Notification');
            $message->embed(public_path('makazi-hub-favicon-black.png'));
        });
    
        return redirect()->route('dashboard')->with('success', 'Booking successful!');
    }


    /**
     * Display a listing of the bookings.
     *
     * @return \Illuminate\View\View
     */
    //
    
    public function index()
    {
        // Fetch bookings for the authenticated user
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)->with('house')->get();

        return view('hunter.view-bookings', compact('bookings'));
    }

    /**
     * Display the specified booking.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    // public function show($id)
    // {
    //     $booking = Booking::findOrFail($id);
    //     return view('bookings.show', compact('booking'));
    // }

    /**
     * Show the form for editing the specified booking.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    // public function edit($id)
    // {
    //     $booking = Booking::findOrFail($id);
    //     return view('bookings.edit', compact('booking'));
    // }

    /**
     * Update the specified booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     // Validate the incoming request data
    //     $validatedData = $request->validate([
    //         'move_in_date' => 'required|date',
    //         'duration' => 'required|integer|min:1|max:30',
    //         'message' => 'nullable|string',
    //     ]);

    //     // Find the booking and update it
    //     $booking = Booking::findOrFail($id);
    //     $booking->move_in_date = $validatedData['move_in_date'];
    //     $booking->duration = $validatedData['duration'];
    //     $booking->message = $validatedData['message'];

    //     // Save the updated booking
    //     $booking->save();

    //     // Redirect back or to a specific page
    //     return redirect()->route('bookings.show', $booking->id)->with('success', 'Booking updated successfully!');
    // }

    /**
     * Remove the specified booking from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     // Find the booking and delete it
    //     $booking = Booking::findOrFail($id);
    //     $booking->delete();

    //     // Redirect back or to a specific page
    //     return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully!');
    // }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('bookings.edit-booking', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'move_in_date' => 'required|date',
            'lease_duration' => 'required|integer|min:1',
            'number_of_occupants' => 'required|integer|min:1',
            'employment_status' => 'required|string',
            'contact_method' => 'required|string',
            'message' => 'nullable|string',
        ]);
    
        // Get the authenticated user's ID
        $user_id = Auth::id();
    
        // Find the booking by ID and ensure it belongs to the authenticated user
        $booking = Booking::where('id', $id)->where('user_id', $user_id)->firstOrFail();
        
        // Update the booking details
        $booking->move_in_date = $request->move_in_date;
        $booking->lease_duration = $request->lease_duration;
        $booking->number_of_occupants = $request->number_of_occupants;
        $booking->employment_status = $request->employment_status;
        $booking->contact_method = $request->contact_method;
        $booking->message = $request->message;
        $booking->save();
    
        // Fetch the house and lister information
        $house = House::findOrFail($booking->house_id);
        $lister = User::findOrFail($house->lister_id);
    
        // Create a notification for the lister
        $notification = new Notification();
        $notification->lister_id = $lister->id;
        $notification->house_id = $house->id;
        $notification->hunter_id = $user_id;
        $notification->message = "A booking has been updated for your house: " . $house->location;
        $notification->save();
    
        // Send an email to the lister with the embedded image
        Mail::send('emails.bookings-update', ['house' => $house, 'booking' => $booking], function($message) use ($lister) {
            $message->to($lister->email);
            $message->subject('Booking Update Notification');
            $message->embed(public_path('makazi-hub-favicon-black.png'));
        });
        return view('bookings.booking-confirmation')->with('success', 'Booking updated successfully.');

    }


    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }
}