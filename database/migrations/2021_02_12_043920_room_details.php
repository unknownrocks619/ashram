<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::defaultStringLength(191);

        Schema::create('room_details',function(Blueprint $table) {
            $table->id()->comment('primary key for the table');
            $table->integer('room_number')->comment('unique id mumber for each room');
            $table->string('room_type',100)->comment('room type includes deluxe, standard etc..');
            $table->integer('room_capacity')->nullable()->comment('No. of people a room can hold');
            $table->string('room_location',100)->comment('');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment('used for soft delete');
            $table->integer('created_by_user')->nullable()->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
            $table->string('room_owner',100)->nullable()->comment('To indentify who donated for the paricular room');


        });      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("room_details");
    }
}
