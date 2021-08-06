<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id');
            $table->foreignId('user_id');
            $table->foreignId('appointment_id');
            $table->longText('findings')->nullable();
            $table->longText('prescription')->nullable();
            $table->longText('recommendation')->nullable();
            $table->string('temperature')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
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
        Schema::dropIfExists('consultations');
    }
}
