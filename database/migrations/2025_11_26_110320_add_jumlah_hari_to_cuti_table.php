<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cuti', function (Blueprint $table) {
            if (!Schema::hasColumn('cuti', 'jumlah_hari')) {
                $table->integer('jumlah_hari')->default(0)->after('tanggal_selesai');
            }
        });
    }

    public function down(): void
    {
        // The base create_cuti_table migration already defines jumlah_hari.
        // Never drop a column owned by an earlier migration.
    }
};
