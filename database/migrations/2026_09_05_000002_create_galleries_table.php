<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('Kegiatan Harian');
            $table->enum('type', ['foto', 'video'])->default('foto');
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->string('duration')->nullable();
            $table->date('taken_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
