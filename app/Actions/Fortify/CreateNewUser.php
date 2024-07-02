<?php
namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
            'phone_number' => ['required', 'string', 'max:10', 'unique:users'],
            'id_number' => ['required', 'string', 'max:10', 'unique:users'],
            'password' => $this->passwordRules(),
            // 'role' => ['required', 'in:lister,hunter'], // Validate role input
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Assign role ID based on the selected role
        $roleId = $input['role'] === 'lister' ? 7 : 8;

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'id_number' => $input['id_number'],
            'roles_id' => $roleId, // Set the role ID
            'password' => Hash::make($input['password']),
        ]);
    }
}
