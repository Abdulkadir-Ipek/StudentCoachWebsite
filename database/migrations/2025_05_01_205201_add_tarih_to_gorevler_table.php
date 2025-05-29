<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gorevler', function (Blueprint $table) {
            $table->timestamp('tarih')->nullable()->after('tamamlanma_orani');
        });
        
        // Mevcut görevlere geçerli zamanı ata
        DB::statement('UPDATE gorevler SET tarih = NOW() WHERE tarih IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gorevler', function (Blueprint $table) {
            $table->dropColumn('tarih');
        });
    }
};
