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
        Schema::create('trips', function (Blueprint $table) {
            $table->id('trip_id');
            $table->dateTime('start_at');
            $table->string('start_from');
            $table->string('destination');
            $table->integer('route_number');
            $table->string('bus_number');
            $table->bigInteger('driver_id');
            $table->bigInteger('conductor_id');
            $table->timestamps();
            $table->foreign('route_number')->references('route_number')->on('routes');
            $table->foreign('bus_number')->references('registration_number')->on('buses');
            $table->foreign('driver_id')->references('user_id')->on('users');
            $table->foreign('conductor_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
