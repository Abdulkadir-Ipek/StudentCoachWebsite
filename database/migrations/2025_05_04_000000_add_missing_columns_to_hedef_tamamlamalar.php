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
        Schema::table('hedef_tamamlamalar', function (Blueprint $table) {
            if (!Schema::hasColumn('hedef_tamamlamalar', 'tarih')) {
                $table->date('tarih')->nullable();
            }
            if (!Schema::hasColumn('hedef_tamamlamalar', 'tamamlandi')) {
                $table->boolean('tamamlandi')->default(true);
            }
            if (!Schema::hasColumn('hedef_tamamlamalar', 'tamamlanma_tarihi')) {
                $table->timestamp('tamamlanma_tarihi')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hedef_tamamlamalar', function (Blueprint $table) {
            $table->dropColumn(['tarih', 'tamamlandi', 'tamamlanma_tarihi']);
        });
    }
}; 