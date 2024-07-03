<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Mail\UserWelcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Actions\Fortify\PasswordValidationRules;


class UserController extends Controller
{

    use PasswordValidationRules;

    public function index(){
        //fetch all non-tenant users
        $tenantRole = Role::where('role_name','Tenant')->first();
        $users = User::where('role_id','!=',$tenantRole->id)->with('role')->paginate(5);
        
        return view('landlord.users.index',compact('users'));
    }

    public function create(){
        $roles = Role::all();
        return view('landlord.users.create',compact('roles'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_number' => ['required','string','max:10','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'phone_number' => ['required','string','max:14','min:10','unique:users'],
            'role_id'=>['required','exists:roles,id']
        ]);

        // Sanitize phone number
        $phoneNumber = preg_replace('/\D/', '', $request->phone_number); // Remove all non-numeric characters
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '254' . substr($phoneNumber, 1);
        } elseif (substr($phoneNumber, 0, 3) !== '254') {
            $phoneNumber = '254' . $phoneNumber;
        }


        //Store the password
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

        //Retrieve the role
        $role = Role::find($role_id);
        $roleName = $role ? $role->role_name : 'Undefined Role';

        //Send email to new user
        Mail::to($user->email)->send(new UserWelcome($user, $password,$roleName));

        return redirect()->route('landlord.users.index')->with('success','User added successfully');
    }

    public function edit(User $user){
        $roles = Role::all();
        return view('landlord.users.edit',compact('user','roles'));
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'role_id'=>['required','exists:roles,id']
        ]);

        // Sanitize phone number
        $phoneNumber = preg_replace('/\D/', '', $request->phone_number); // Remove all non-numeric characters
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '254' . substr($phoneNumber, 1);
        }

        // 'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],

        //Update the user
        $user->update([
            'name' =>$request->name,
            'email'=>$request->email,
            'phone_number'=>$phoneNumber,
            'id_number'=>$request->id_number,
            'role_id' => $request->role_id
        ]);

        return redirect()->route('landlord.users.index')->with('success','User updated successfully');

    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->route('landlord.users.index')->with('success','User deleted successfully');
    }
}
