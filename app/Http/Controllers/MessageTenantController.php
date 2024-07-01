<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Message;
use App\Mail\TenantMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Notifications\LandlordNotification;



class MessageTenantController extends Controller
{
    public function index()
    {
        $messages = Message::with('tenant.user')->paginate(5);
        return view('landlord.messages.index', compact('messages'));
    }

    public function create()
    {
        $tenants = Tenant::with('user')->get();
        return view('landlord.messages.create', compact('tenants'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $message = $request->message;
        $subject = $request->subject;

        $tenant = Tenant::with('user')->findOrFail($request->tenant_id);
        $tenantUser = $tenant->user;

        Message::create([
            'user_id' => Auth::id(),
            'tenant_id' => $request->tenant_id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Get our 'from' number
        $landlordId = 1;
        $landlord = User::find($landlordId); // Replace with your landlord's user ID
        $landlordNumber = $landlord->phone_number;

        // Notify the tenant
        $tenantUser->notify(new LandlordNotification($message,$landlordNumber));

        Mail::to($tenant->user->email)->send(new TenantMessage($tenant,$message,$subject));

        return redirect()->route('landlord.messages.index')->with('success', 'Message sent successfully.');
    }
}
