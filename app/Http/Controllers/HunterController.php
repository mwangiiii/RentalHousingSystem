<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\House;
use App\Models\Notification;
use App\Models\SavedHouse;
use Carbon\Carbon;
use Auth;
use App\Models\User;

class HunterController extends Controller
{
    public function search()
    {
        return view('hunter.search');
    }

    public function saved()
    {
        $userId = auth()->id();
        $savedHouses = SavedHouse::where('user_id', $userId)->with('house')->get();
        return view('hunter.save', compact('savedHouses'));
    }

    public function notifications()
    {
        return view('hunter.notifications');
    }

    public function messages()
    {
        return view('hunter.messages');
    }

    public function profile()
    {
        return view('hunter.profile');
    }

    public function scheduleViewing(Request $request)
    {
        // Validate the request
        $request->validate([
            'house_id' => 'required|exists:houses,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);
    
        try {
            $hunterId = auth()->id(); // Assuming the hunter is the authenticated user
            // Debugging step: Check if hunterId is valid
            \Log::info('Hunter ID: ' . $hunterId);
    
            $hunter = User::findOrFail($hunterId); // Fetch the hunter's data
            $house = House::findOrFail($request->house_id);
            $lister = User::findOrFail($house->lister_id); // Assuming the lister_id is a reference to the users table
    
            // Combine date and time into a single Carbon instance
            $viewingTime = Carbon::parse($request->date . ' ' . $request->time);
    
            // Create the notification
            Notification::create([
                'lister_id' => $lister->id,
                'house_id' => $house->id,
                'hunter_id' => $hunterId,
                'message' => "Viewing scheduled for house {$house->name} on " . $viewingTime->format('Y-m-d H:i:s') . ".",
                'viewing_time' => $viewingTime,
            ]);
    
            // Send email to lister
            Mail::send('emails.schedule_viewing', ['house' => $house, 'viewingTime' => $viewingTime], function ($message) use ($lister) {
                $message->to($lister->email)
                        ->subject('House Viewing Request');
            });
    
            // Send email to hunter
            Mail::send('emails.notify_hunter', ['house' => $house, 'viewingTime' => $viewingTime, 'lister' => $lister], function ($message) use ($hunter) {
                $message->to($hunter->email)
                        ->subject('House Viewing Scheduled');
            });
    
            return redirect()->back()->with('success', 'Viewing scheduled and notifications sent to both lister and hunter.');
        } catch (\Exception $e) {
            \Log::error('Error scheduling viewing: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while scheduling the viewing. Please try again later.');
        }
    }
    

    public function saveHouse(Request $request)
    {
        $userId = auth()->id();
        $query = SavedHouse::where('user_id', $userId)->with('house');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('house', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        $savedHouses = $query->paginate(10);
        return view('hunter.saved', compact('savedHouses'));
    }
}
