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
            // Önce varolan foreign key kısıtlamasını kaldır
            $table->dropForeign(['hedef_id']);
            
            // Foreign key'i haftalik_hedefler tablosuna bağla
            $table->foreign('hedef_id')->references('id')->on('haftalik_hedefler')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hedef_tamamlamalar', function (Blueprint $table) {
            // Eski haline geri döndür
            $table->dropForeign(['hedef_id']);
            
            // Eğer gunluk_hedefler tablosu varsa ona bağla
            $table->foreign('hedef_id')->references('id')->on('gunluk_hedefler')->onDelete('cascade');
        });
    }
};
