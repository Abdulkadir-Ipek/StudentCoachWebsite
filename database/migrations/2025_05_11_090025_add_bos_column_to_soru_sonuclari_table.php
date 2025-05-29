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
            $table->integer('bos')->default(0)->after('yanlis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soru_sonuclari', function (Blueprint $table) {
            $table->dropColumn('bos');
        });
    }
};
