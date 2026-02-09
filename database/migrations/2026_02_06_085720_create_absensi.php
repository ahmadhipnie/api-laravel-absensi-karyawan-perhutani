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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('clock_in')->nullable();
            $table->string('clock_in_image')->nullable();
            $table->string('clock_in_lat')->nullable();
            $table->string('clock_in_long')->nullable();
            $table->string('clock_out')->nullable();
            $table->string('clock_out_image')->nullable();
            $table->string('clock_out_lat')->nullable();
            $table->string('clock_out_long')->nullable();
            $table->integer('late_duration')->default(0);
            $table->enum('status', ['hadir', 'izin', 'sakit', 'terlambat'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
