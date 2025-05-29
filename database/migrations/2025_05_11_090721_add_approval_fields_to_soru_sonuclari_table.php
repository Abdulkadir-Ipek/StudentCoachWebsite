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
            $table->enum('onay_durumu', ['beklemede', 'onaylandi', 'reddedildi'])->default('beklemede')->after('tarih');
            $table->timestamp('onay_tarihi')->nullable()->after('onay_durumu');
            $table->text('not')->nullable()->after('onay_tarihi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soru_sonuclari', function (Blueprint $table) {
            $table->dropColumn(['onay_durumu', 'onay_tarihi', 'not']);
        });
    }
};
