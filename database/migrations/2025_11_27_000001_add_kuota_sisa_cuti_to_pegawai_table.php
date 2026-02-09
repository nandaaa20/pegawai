<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            if (!Schema::hasColumn('pegawai', 'kuota_cuti')) {
                $table->integer('kuota_cuti')->default(0)->after('status_kepegawaian');
            }
            if (!Schema::hasColumn('pegawai', 'sisa_cuti')) {
                $table->integer('sisa_cuti')->default(0)->after('kuota_cuti');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            if (Schema::hasColumn('pegawai', 'sisa_cuti')) {
                $table->dropColumn('sisa_cuti');
            }
            if (Schema::hasColumn('pegawai', 'kuota_cuti')) {
                $table->dropColumn('kuota_cuti');
            }
        });
    }
};
