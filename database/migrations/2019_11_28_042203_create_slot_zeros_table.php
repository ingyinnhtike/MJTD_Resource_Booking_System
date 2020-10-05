<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotZerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slot_zeros', function (Blueprint $table) {
            $table->increments('id');
            $table->text('time_slot_0')->nullable();
            $table->text('time_slot_1')->nullable();
            $table->text('time_slot_2')->nullable();
            $table->text('time_slot_3')->nullable();
            $table->text('time_slot_4')->nullable();
            $table->text('time_slot_5')->nullable();
            $table->text('time_slot_6')->nullable();
            $table->string('schedule_id');
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
        Schema::dropIfExists('slot_zeros');
    }
}
