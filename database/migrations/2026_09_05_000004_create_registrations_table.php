<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('ttl');
            $table->string('wali');
            $table->string('whatsapp');
            $table->string('program');
            $table->enum('status', ['baru', 'diproses', 'diterima', 'ditolak'])->default('baru');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
