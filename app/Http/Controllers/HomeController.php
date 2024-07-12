<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\House;

class HomeController extends Controller
{
    public function dashboard()
    {
        // Check if the user is authenticated
        if (Auth::check()) {

            // Check if session is locked
            if (session('lock-screen')) {
                // Save current URL to return to after unlocking
                session(['previous-url' => url()->current()]);
                return redirect()->route('lock-screen');
            }

            // Get the authenticated user and their role ID
            $user = Auth::user();
            $roleId = $user->role_id; // Ensure 'role_id' exists in users table

            // Determine which dashboard view to return based on the user's role ID
            switch ($roleId) {
                case 1:
                    return redirect()->route('admin.dashboard'); // Admin dashboard
                case 2:
                    return redirect()->route('landlord.dashboard'); // Landlord dashboard
                case 3:
                    return redirect()->route('manager.dashboard'); // Property Manager dashboard
                case 4:
                    return redirect()->route('tenant.dashboard'); // Tenant dashboard
                case 5:
                    return redirect()->route('accountant.dashboard'); // Accountant dashboard
                case 6:
                    return redirect()->route('maintenance.dashboard'); // Maintenance Worker dashboard
                case 7:
                    // Fetch houses listed by this user
                    $houses = House::where('user_id', $user->id)->get();
                    return view('lister.dashboard', ['houses' => $houses]); // House Lister dashboard
                case 8:
                    return redirect()->route('hunter.dashboard'); // House Hunter dashboard
                default:
                    return redirect()->route('tenant.dashboard'); // Default to tenant dashboard for other users
            }

        } else {
            // User is not authenticated, redirect to login page
            return redirect()->route('login');
        }
    }

    public function locations()
    {
        // Your logic for handling locations
    }
    
    public function index()
    {
        $houses = House::all(); // Example: fetch all houses from database
        return view('hunter.dashboard', compact('houses'));
    }

    public function home()
    {
        $houses = House::with('images')->orderBy('created_at', 'desc')->get();
        return view('home', compact('houses'));
    }
}
