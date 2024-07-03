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
            $table->id(); // This is an unsignedBigInteger by default
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lister_id');
            $table->string('location');
            $table->decimal('price', 10, 2);
            $table->text('description');
            $table->enum('availability', ['available', 'unavailable']);
            $table->string('contact');
            $table->text('rules_and_regulations')->nullable();
            $table->string('amenities');
            $table->unsignedBigInteger('category_id'); // Define category_id as unsignedBigInteger
            $table->string('main_image');
            $table->timestamps();

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
