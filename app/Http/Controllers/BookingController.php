<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\House;
use Illuminate\Support\Facades\Auth;

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
        return view('booking', compact('house'));
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'move_in_date' => 'required|date',
            'duration' => 'required|integer|min:1|max:30',
            'message' => 'nullable|string',
        ]);

        // Create a new booking instance
        $booking = new Booking();
        $booking->house_id = $validatedData['house_id'];
        $booking->move_in_date = $validatedData['move_in_date'];
        $booking->duration = $validatedData['duration'];
        $booking->message = $validatedData['message'];
        $booking->user_id = Auth::id(); // Assuming authenticated user

        // Save the booking
        $booking->save();

        // Redirect back or to a thank-you page
        return redirect()->back()->with('success', 'Booking successful!');
    }

    /**
     * Display a listing of the bookings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->get();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Display the specified booking.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'move_in_date' => 'required|date',
            'duration' => 'required|integer|min:1|max:30',
            'message' => 'nullable|string',
        ]);

        // Find the booking and update it
        $booking = Booking::findOrFail($id);
        $booking->move_in_date = $validatedData['move_in_date'];
        $booking->duration = $validatedData['duration'];
        $booking->message = $validatedData['message'];

        // Save the updated booking
        $booking->save();

        // Redirect back or to a specific page
        return redirect()->route('bookings.show', $booking->id)->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the booking and delete it
        $booking = Booking::findOrFail($id);
        $booking->delete();

        // Redirect back or to a specific page
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully!');
    }
}
