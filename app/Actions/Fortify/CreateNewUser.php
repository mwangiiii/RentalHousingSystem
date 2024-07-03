<?php
namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Models\Lister;
use App\Models\Hunter;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required','string','max:14','min:10','unique:users'],
            'id_number' => ['required','string','max:10','unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Sanitize phone number
        $phoneNumber = preg_replace('/\D/', '', $input['phone_number']); // Remove all non-numeric characters
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '254' . substr($phoneNumber, 1);
        }

        // dd($input['role']);

        
        // Create the user
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $phoneNumber,
            'id_number' => $input['id_number'],
            'role_id' => $input['role'] === 'lister' ? 9 : 10, // Conditional role assignment
            'password' => Hash::make($input['password']),
        ]);

        // Create a Lister if the role is 'lister'
        if ($input['role'] === 'lister') {
            
            Lister::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'contact' => $user->phone_number,
                'email' => $user->email,
                'identification_number' => $user->id_number,
                'password' => Hash::make($input['password']),
            ]);
        }else{
            Hunter::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'contact' => $user->phone_number,
                'email' => $user->email,
                'identification_number' => $user->id_number,
                'password' => Hash::make($input['password']),
            ]);
        }
        return $user;
    }
}
