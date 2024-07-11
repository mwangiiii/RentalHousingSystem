<?php
namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use App\Models\Lister;
// use App\Models\Hunter;
// use App\Models\Role;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Auth\Events\Registered;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\Rules\Password;

class ListerController extends Controller
{
    // Show lister dashboard
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