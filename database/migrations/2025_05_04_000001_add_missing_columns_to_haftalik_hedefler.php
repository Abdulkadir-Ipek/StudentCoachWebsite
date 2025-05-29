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
        Schema::table('haftalik_hedefler', function (Blueprint $table) {
            if (!Schema::hasColumn('haftalik_hedefler', 'coach_id')) {
                $table->foreignId('coach_id')->constrained('users');
            }
            if (!Schema::hasColumn('haftalik_hedefler', 'gun')) {
                $table->enum('gun', ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar']);
            }
            if (!Schema::hasColumn('haftalik_hedefler', 'ders_adi')) {
                $table->string('ders_adi');
            }
            if (!Schema::hasColumn('haftalik_hedefler', 'hedef_soru')) {
                $table->integer('hedef_soru');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('haftalik_hedefler', function (Blueprint $table) {
            $table->dropColumn(['coach_id', 'gun', 'ders_adi', 'hedef_soru']);
        });
    }
}; 