<?php

namespace App\Http\Controllers;


use App\Models\Room;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\TenantWelcomeMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Actions\Fortify\PasswordValidationRules;


class TenantController extends Controller
{
    use PasswordValidationRules;

    public function index(Request $request)
    {
        $landlord = auth()->user();

        // Get tenants associated with the landlord's properties
        $tenants = Tenant::whereHas('property', function ($query) use ($landlord) {
            $query->where('user_id', $landlord->id);
        })->with(['user', 'property', 'room'])->get();

        return view('landlord.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $rooms = Room::all();
        $properties = Property::all();

        return view('landlord.tenants.create', compact('rooms', 'properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:10', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'phone_number' => ['required', 'string', 'max:14', 'min:10', 'unique:users'],
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'required|exists:rooms,id',
            'lease_start' => 'required|date',
            'lease_end' => 'required|date|after:lease_start'
        ]);

        // Sanitize phone number
        $phoneNumber = preg_replace('/\D/', '', $request->phone_number); // Remove all non-numeric characters
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '254' . substr($phoneNumber, 1);
        } elseif (substr($phoneNumber, 0, 3) !== '254') {
            $phoneNumber = '254' . $phoneNumber;
        }

        //Create the user
        $password = $request->password;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $phoneNumber,
            'id_number' => $request->id_number,
            'role_id' => 4,
            'password' => Hash::make($request->password),
        ]);

        Tenant::create([
            'user_id' => $user->id,
            'property_id' => $request->property_id,
            'room_id' => $request->room_id,
            'lease_start' => $request->lease_start,
            'lease_end' => $request->lease_end,
            'move_in_date' => date('Y-m-d')
        ]);

        // Load the role relationship
        $user->load('role');

        // Generate the rental agreement PDF
        $pdf = Pdf::loadView('pdf.rental-agreement', [
            'landlord' => auth()->user(),
            'tenant' => $user,
            'property' => Property::find($request->property_id),
            'room' => Room::find($request->room_id),
            'leaseStart' => $request->lease_start,
            'leaseEnd' => $request->lease_end,
            'move_in_date' => date('Y-m-d')
        ]);

        // Save the PDF to the storage
        $pdfPath = 'rental-agreements/' . $user->id . '.pdf';
        Storage::put($pdfPath, $pdf->output());

        //Send email to tenant
        Mail::to($user->email)->send(new TenantWelcomeMail($user, $password, Storage::path($pdfPath)));

        return redirect()->route('landlord.tenants.index')->with('success', 'Tenant added successfully');
    }

    public function edit(Tenant $tenant)
    {
        $properties = Property::all();
        $rooms = Room::all();
        return view('landlord.tenants.edit', compact('tenant', 'rooms', 'properties'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $tenant->user_id,
            'phone_number' => 'required', 'string', 'max:14', 'min:10', 'unique:users', Rule::unique('users')->ignore($tenant->user_id),
            'id_number' => 'required|string|max:255', Rule::unique('users')->ignore($tenant->user_id),
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'required|exists:rooms,id',
            'lease_start' => 'required|date',
            'lease_end' => 'required|date|after:lease_start',
        ]);

        // Sanitize phone number
        $phoneNumber = preg_replace('/\D/', '', $request->phone_number); // Remove all non-numeric characters
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '254' . substr($phoneNumber, 1);
        }

        //Update the user
        $tenant->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $phoneNumber,
            'id_number' => $request->id_number
        ]);

        //Update Tenant 
        $tenant->update([
            'property_id' => $request->property_id,
            'room_id' => $request->room_id,
            'lease_start' => $request->lease_start,
            'lease_end' => $request->lease_end
        ]);

        return redirect()->route('landlord.tenants.index')->with('success', 'Tenant updated successfully');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->user()->delete();
        $tenant->delete();

        return redirect()->route('landlord.tenants.index')->with('success', 'Tenant deleted successfully');
    }

    // Tenant Check out
    public function checkout(Tenant $tenant)
    {
        $tenant->user()->delete(); // Fetch the associated user and delete it

        $tenant->delete(); // Delete the tenant record 

        return redirect()->route('landlord.tenants.index')->with('success', 'Tenant checked out and deleted successfully');
    }
}
