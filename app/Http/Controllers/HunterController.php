<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\House;
use App\Models\Notification;
use App\Models\SavedHouse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactAgentMail;



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
            Log::info('Hunter ID: ' . $hunterId);
    
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
            Log::error('Error scheduling viewing: ' . $e->getMessage());
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


    public function dashboard()
    {
        $houses = House::with('category', 'images')->get();
        return view('hunter.dashboard', compact('houses'));
    }

    public function show($id)
    {
        // Retrieve the house details from the database
        $house = House::findOrFail($id); // Adjust if using different logic to fetch house

        // Pass the $house object to a view to display details
        return view('hunter.houses-info', ['house' => $house]);
    }

    public function contactAgent(Request $request, $houseId)
    {
        // Retrieve the house details
        $house = House::findOrFail($houseId);
    
        // Retrieve the lister's email using the lister_id in the houses table
        $lister = User::findOrFail($house->lister_id);
        $listerEmail = $lister->email;
    
        // Get the hunter (current user)
        $hunter = Auth::user();
    
        // Send the email to the lister
        Mail::send('emails.contact-agent', ['house' => $house, 'hunter' => $hunter], function($message) use ($listerEmail) {
            $message->to($listerEmail)
                    ->subject('Contact Request for Your House Listing')
                    ->embed(public_path('makazi-hub-favicon-black.png'), [
                        'as' => 'makazi-hub-favicon-black.png',
                        'mime' => 'image/png',
                    ]);
        });
    

    
        // Create a notification
        Notification::create([
            'lister_id' => $house->lister_id,
            'house_id' => $houseId,
            'hunter_id' => $hunter->id,
            'message' => 'A hunter has contacted you regarding your house listing.',
            'is_read' => false,
        ]);
    
        return view('hunter.contact-agent-confirmation');
    }
    
    


    // public function contactAgent($houseId, Request $request)
    // {
    //     $house = House::findOrFail($houseId);
    //     $agentEmail = $house->agent->email; // Assuming the house has an agent relationship

    //     $details = [
    //         'title' => 'New Contact Request for Your House Listing',
    //         'house' => $house
    //     ];

    //     Mail::to($agentEmail)->send(new \App\Mail\ContactAgentMail($details));

    //     return response()->json(['success' => true]);
    // }


    public function hunter()
    {
        
        // Retrieve houses with their listers and main images
        $houses = House::with(['lister', 'images' => function($query) {
            $query->where('is_main', true);
        }])
        ->orderBy('created_at', 'desc')
        ->get();
    
        // Add a mainImage attribute to each house
        $houses->each(function($house) {
            $house->mainImage = $house->images->first();
        });
    
        return view('hunter.dashboard', compact('houses','images'));
    }
}
