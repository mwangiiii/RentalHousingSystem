<?php

use App\Models\Property;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Property::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Room::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->date('lease_start');
            $table->date('lease_end');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
