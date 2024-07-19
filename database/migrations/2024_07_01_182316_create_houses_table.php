<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key for users table
            $table->unsignedBigInteger('lister_id'); // Foreign key for users table
            $table->string('location', 255); // Location of the house
            $table->decimal('price', 10, 2); // Price of the house
            $table->text('description'); // Description of the house
            $table->enum('availability', ['available', 'unavailable', 'booked']); // Availability status
            $table->string('contact', 255); // Contact information
            $table->text('rules_and_regulations')->nullable(); // Rules and regulations, nullable
            $table->text('amenities'); // Amenities
            $table->unsignedBigInteger('category_id'); // Foreign key for categories table
            $table->timestamps(); // Timestamps for created_at and updated_at

            // Adding foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lister_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houses');
    }
};
