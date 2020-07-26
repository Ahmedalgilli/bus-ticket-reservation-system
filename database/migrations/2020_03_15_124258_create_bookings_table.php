<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            // $table->id();
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('invoice_id');
            // $table->boolean('payed')->default(0);
            $table->json('customers');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
