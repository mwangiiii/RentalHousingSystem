<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Role;

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

            // Get the authenticated user and their role
            $user = Auth::user();
            $role = Role::find($user->role_id);

            // Determine which dashboard view to return based on the user's role
            if ($role && $role->role_name === 'Admin') {
                return view('admin.dashboard'); // Redirect to admin dashboard if user is admin
            } elseif ($role && $role->role_name === 'Property Manager') {
                return view('manager.dashboard'); // Redirect to dashboard if user is property manager
            } else {
                return view('tenant.dashboard'); // Redirect to tenant dashboard for other users
            }

           

        } else {
            // User is not authenticated, redirect to login page
            return view('auth.login');
        }
    }
}
