<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('group')->default('umum'); // umum | pendidikan
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('timeline_events', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('daily_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('time');
            $table->string('activity');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('group'); // beranda, profil, pendidikan, kegiatan, berita, galeri, kontak, pendaftaran
            $table->string('key')->unique();
            $table->string('label');
            $table->string('type')->default('textarea'); // text | textarea
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        Schema::table('site_profiles', function (Blueprint $table) {
            $table->string('map_embed')->nullable()->after('tiktok');
            $table->text('features')->nullable()->after('pengasuh_bio'); // newline list
            $table->text('registration_docs')->nullable()->after('features');
            $table->text('registration_programs')->nullable()->after('registration_docs');
        });
    }

    public function down(): void
    {
        Schema::table('site_profiles', function (Blueprint $table) {
            $table->dropColumn(['map_embed', 'features', 'registration_docs', 'registration_programs']);
        });
        Schema::dropIfExists('page_contents');
        Schema::dropIfExists('daily_schedules');
        Schema::dropIfExists('timeline_events');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('programs');
    }
};
