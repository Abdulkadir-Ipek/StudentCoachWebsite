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
        Schema::table('gorevler', function (Blueprint $table) {
            $table->text('aciklama')->after('gorev_adi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gorevler', function (Blueprint $table) {
            $table->dropColumn('aciklama');
        });
    }
};
