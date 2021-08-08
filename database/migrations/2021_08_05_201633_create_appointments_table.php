<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::enableForeignKeyConstraints();

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('schedule');
            $table->string('reason');
            $table->foreignId('patient_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable();
            $table->boolean('done')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('appointments');
    }
}
