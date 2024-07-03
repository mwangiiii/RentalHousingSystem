<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            User::all()->each(function($user) {
                $phoneNumber = preg_replace('/\D/', '', $user->phone_number); // Remove all non-numeric characters
                
                // Check if the phone number starts with '0' and prepend '254'
                if (substr($phoneNumber, 0, 1) === '0') {
                    $phoneNumber = '254' . substr($phoneNumber, 1);
                }
    
                // Save the updated phone number
                $user->phone_number = $phoneNumber;
                $user->save();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
