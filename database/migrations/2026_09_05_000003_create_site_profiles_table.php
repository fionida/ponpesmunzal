<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->string('motto')->nullable();
            $table->text('about')->nullable();
            $table->text('history')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('goals')->nullable();
            $table->string('pengasuh_name')->nullable();
            $table->string('pengasuh_title')->nullable();
            $table->text('pengasuh_bio')->nullable();
            $table->string('pengasuh_photo')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('hours')->nullable();
            $table->string('stat_years')->nullable();
            $table->string('stat_students')->nullable();
            $table->string('stat_teachers')->nullable();
            $table->string('stat_alumni')->nullable();
            $table->string('youtube')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_profiles');
    }
};
