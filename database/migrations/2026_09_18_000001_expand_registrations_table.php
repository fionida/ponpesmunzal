<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('jenis_kelamin', 20)->nullable()->after('nama');
            $table->string('tempat_lahir', 80)->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->string('sekolah_asal')->nullable()->after('alamat');
            $table->string('hubungan_wali', 40)->nullable()->after('wali');
            $table->string('email_wali')->nullable()->after('whatsapp');
            $table->text('catatan')->nullable()->after('program');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'sekolah_asal',
                'hubungan_wali',
                'email_wali',
                'catatan',
            ]);
        });
    }
};
