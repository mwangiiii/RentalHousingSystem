<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

class LockScreenController extends Controller
{
    public function lockscreen(){
        if(!session('lock-screen')){
            return redirect()->route('dashboard');
        }
        return view ('lock-screen');
    }

    public function unlock(Request $request){

        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if(Hash::check($request->password, $user->password)){
            Session::forget('lock-screen');
            return redirect()->intended(session('previous-url'));
        }
        return back()->withErrors(['password' => 'The provided password is incorrect']);
    }

    public function manualLock(Request $request)
    {
        session(['lock-screen' => true]);
        session(['previous-url' => url()->previous()]);
        return redirect()->route('lock-screen');
    }

    public function autoLock(Request $request)
    {
        session(['lock-screen' => true]);
        session(['previous-url' => url()->previous()]);
        return response()->json(['locked' => true]);
    }

}
