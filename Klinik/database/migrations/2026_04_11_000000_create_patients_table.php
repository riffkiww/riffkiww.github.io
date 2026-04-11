<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('medical_record_number', 30)->unique();
            $table->string('full_name', 150);
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->text('complaint');
            $table->text('notes')->nullable();
            $table->enum('status', ['Aktif', 'Selesai', 'Rujuk'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};