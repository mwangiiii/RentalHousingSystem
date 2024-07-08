<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Ensure InnoDB engine is used
            $table->id(); // Creates an unsigned big integer as the primary key
            $table->unsignedBigInteger('house_id'); // Foreign key referencing the houses table
            $table->string('name');
            $table->string('phone_number');
            $table->string('email');
            $table->date('check_in_date');
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed'])->default('pending');
            $table->enum('payment_status', ['pending', 'completed', 'refunded'])->default('pending');
            $table->string('payment_method');
            $table->string('transaction_id');
            $table->text('additional_notes');
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
