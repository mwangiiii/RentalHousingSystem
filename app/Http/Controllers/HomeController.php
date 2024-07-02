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
        if (Auth::check()){
            // Check if session is locked
            if (session('screen_locked')) {
                // Save current URL to return to after unlocking
                session(['previous-url' => url()->current()]);
                return redirect()->route('lock-screen');
            }

            // Get the authenticated user and their role
            $user = Auth::user();
            $role = Role::find($user->role_id);

            // Determine which dashboard view to return based on the user's role
            if ($role && $role->role_name === 'Admin') {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard if user is admin
            } elseif ($role && $role->role_name === 'Property Manager') {
                return view('manager.dashboard'); // Redirect to dashboard if user is property manager
            }
            elseif ($role && $role->role_name === 'Maintenance Worker') {
                return view('maintenance.dashboard'); // Redirect to dashboard if user is property manager
            } 
            elseif($role && $role->role_name === 'Lister'){
                return redirect()->route('lister.dashboard'); // House Lister dashboard
            }
            elseif($role && $role->role_name === 'House Hunter'){
                return redirect()->route('hunter.dashboard'); // House Hunter dashboard
            }
            else {
                return redirect()->route('tenant.dashboard'); // Redirect to tenant dashboard for other users
            }
        } else {
            // User is not authenticated, redirect to login page
            return view('auth.login');
        }
    }
    public function locations()
    {
        // Your logic for handling locations
    }
    public function hunter()
    {
        // Retrieve houses with their main images
        $houses = House::with(['images' => function($query) {
            $query->where('is_main', '!=', null); // Ensure this matches your column logic
        }])->get();

        // Pass the houses data to the view
        return view('hunter.dashboard', compact('houses'));
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
