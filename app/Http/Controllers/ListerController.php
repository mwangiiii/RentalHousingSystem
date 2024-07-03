<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lister;
use App\Models\Hunter;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ListerController extends Controller
{
    // Show registration form for lister
    // public function showListerForm()
    // {
    //     return view('auth.register-lister');
    // }

    // Handle lister registration
    // public function storeLister(Request $request)
    // {
    //     // Validate user input
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => ['required', 'confirmed', Password::defaults()],
    //         'phone_number' => 'required|string|max:20',
    //         'id_number' => 'required|string|max:20|unique:users,id_number|unique:listers,identification_number',
    //         'role' => 'required|in:lister,hunter', // Validate role input
    //     ]);
    
    //     \DB::beginTransaction();
    
    //     try {
    //         // Create the user in the users table
    //         $user = User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password),
    //             'phone_number' => $request->phone_number,
    //             'id_number' => $request->id_number,
    //         ]);
    // dd('hi');
    //         // Determine role ID based on the selected role and create corresponding record
    //         if ($request->role === 'lister') {
    //             $role = Role::where('name', 'Lister')->firstOrFail();
    //             Lister::create([
    //                 'user_id' => $user->id,
    //                 'name' => $user->name,
    //                 'contact' => $user->phone_number,
    //                 'email' => $user->email,
    //                 'identification_number' => $user->id_number,
    //                 'password' => Hash::make($request->password),
    //             ]);
    //         } elseif ($request->role === 'hunter') {
    //             $role = Role::where('name', 'House Hunter')->firstOrFail();
    //             Hunter::create([
    //                 'user_id' => $user->id,
    //                 'name' => $user->name,
    //                 'contact' => $user->phone_number,
    //                 'email' => $user->email,
    //                 'identification_number' => $user->id_number,
    //                 'password' => Hash::make($request->password),
    //             ]);
    //         } else {
    //             throw new \Exception('Invalid role selected.');
    //         }
    
    //         // Assign roles_id to the user
    //         $user->roles_id = $role->id;
    //         $user->save();
    
    //         // Commit transaction if all steps succeed
    //         \DB::commit();
    
    //         // Trigger event for registered user
    //         event(new Registered($user));
    
    //         // Send email verification notification
    //         $user->sendEmailVerificationNotification();
    
    //         // Redirect to appropriate dashboard based on role
    //         return $request->role === 'lister' 
    //             ? redirect()->route('lister.dashboard') 
    //             : redirect()->route('hunter.dashboard');
    
    //     } catch (\Exception $e) {
    //         // Rollback transaction on error
    //         \DB::rollBack();
    
    //         // Return back with error message
    //         return back()->withErrors(['error' => $e->getMessage()]);
    //     }
    // }
    
    // // Show login form
    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }

  

    // Handle user login
    // public function login(Request $request)
    // {
    //     // Validate login credentials
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     // Attempt to authenticate user
    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();

    //         // Check if user is verified
    //         if (!$user->hasVerifiedEmail()) {
    //             Auth::logout(); // Log out user if email is not verified
    //             return redirect()->route('verification.notice')
    //                 ->with('status', 'You need to verify your email address.');
    //         }

    //         // Redirect user based on role
    //         $roleId = $user->roles_id;
    //         switch ($roleId) {
    //             case 1:
    //                 return redirect()->route('admin.dashboard');
    //             case 2:
    //                 return redirect()->route('landlord.dashboard');
    //             case 3:
    //                 return redirect()->route('manager.dashboard');
    //             case 4:
    //                 return redirect()->route('tenant.dashboard');
    //             case 5:
    //                 return redirect()->route('accountant.dashboard');
    //             case 6:
    //                 return redirect()->route('maintenance.dashboard');
    //             case 7:
    //                 return redirect()->route('lister.dashboard');
    //             case 8:
    //                 return redirect()->route('hunter.dashboard');
    //             default:
    //                 return redirect()->route('tenant.dashboard'); // Default dashboard
    //         }
    //     }

    //     // Redirect back on authentication failure
    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }

    // // Logout user
    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }

    // // Show lister dashboard
    public function showListerDashboard()
    {
        return view('lister.dashboard');
    }

    // Show hunter dashboard
    public function showHunterDashboard()
    {
        return view('hunter.dashboard');
    }
}
