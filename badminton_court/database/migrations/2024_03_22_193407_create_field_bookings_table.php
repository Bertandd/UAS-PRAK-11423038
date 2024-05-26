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
        Schema::create('field_bookings', function (Blueprint $table) {
            $table->id();
            //user_id, field_id, date, start_time, end_time
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('field_id')->constrained('fields');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_bookings');
    }
};
