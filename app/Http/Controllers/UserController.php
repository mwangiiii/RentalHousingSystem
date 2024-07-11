<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Mail\UserWelcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Actions\Fortify\PasswordValidationRules;
use Exception;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function index()
    {
        try {
            $tenantRole = Role::where('role_name', 'Tenant')->first();
            $adminRole = Role::where('role_name', 'Admin')->first();
            $users = User::whereNotIn('role_id', [$tenantRole->id, $adminRole->id])
                ->with('role')
                ->paginate(5);
            return view('landlord.users.index', compact('users'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch users.');
        }
    }

    public function create()
    {
        try {
            $roles = Role::all();
            return view('landlord.users.create', compact('roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load the create user form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'id_number' => ['required', 'string', 'max:10', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'phone_number' => ['required', 'string', 'max:14', 'min:10', 'unique:users'],
                'role_id' => ['required', 'exists:roles,id']
            ]);

            $phoneNumber = preg_replace('/\D/', '', $request->phone_number);
            if (substr($phoneNumber, 0, 1) === '0') {
                $phoneNumber = '254' . substr($phoneNumber, 1);
            } elseif (substr($phoneNumber, 0, 3) !== '254') {
                $phoneNumber = '254' . $phoneNumber;
            }

            $password = $request->password;
            $role_id = $request->role_id;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $phoneNumber,
                'id_number' => $request->id_number,
                'role_id' => $request->role_id,
                'password' => Hash::make($request->password),
            ]);

            $role = Role::find($role_id);
            $roleName = $role ? $role->role_name : 'Undefined Role';

            Mail::to($user->email)->send(new UserWelcome($user, $password, $roleName));

            return redirect()->route('landlord.users.index')->with('success', 'User added successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to create user.');
        }
    }

    public function edit(User $user)
    {
        try {
            $roles = Role::all();
            return view('landlord.users.edit', compact('user', 'roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to load the edit user form.');
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'phone_number' => 'nullable|string|max:255',
                'id_number' => 'nullable|string|max:255',
                'role_id' => ['required', 'exists:roles,id']
            ]);

            $phoneNumber = preg_replace('/\D/', '', $request->phone_number);
            if (substr($phoneNumber, 0, 1) === '0') {
                $phoneNumber = '254' . substr($phoneNumber, 1);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $phoneNumber,
                'id_number' => $request->id_number,
                'role_id' => $request->role_id
            ]);

            return redirect()->route('landlord.users.index')->with('success', 'User updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user.');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('landlord.users.index')->with('success', 'User deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user.');
        }
    }
}