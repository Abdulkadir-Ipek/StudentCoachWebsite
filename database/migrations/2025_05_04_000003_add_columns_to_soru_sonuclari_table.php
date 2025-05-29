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
        Schema::table('soru_sonuclari', function (Blueprint $table) {
            // Add ders_adi column if it doesn't exist
            if (!Schema::hasColumn('soru_sonuclari', 'ders_adi')) {
                $table->string('ders_adi')->after('gorev_id');
            }
            
            // Rename columns if they don't match expected names
            if (Schema::hasColumn('soru_sonuclari', 'cozulen_soru') && !Schema::hasColumn('soru_sonuclari', 'cozuldu_soru')) {
                $table->renameColumn('cozulen_soru', 'cozuldu_soru');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soru_sonuclari', function (Blueprint $table) {
            // Reverse rename if needed
            if (Schema::hasColumn('soru_sonuclari', 'cozuldu_soru') && !Schema::hasColumn('soru_sonuclari', 'cozulen_soru')) {
                $table->renameColumn('cozuldu_soru', 'cozulen_soru');
            }
            
            // Remove ders_adi column if it was added by this migration
            if (Schema::hasColumn('soru_sonuclari', 'ders_adi')) {
                $table->dropColumn('ders_adi');
            }
        });
    }
}; 