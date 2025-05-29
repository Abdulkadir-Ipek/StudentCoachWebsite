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
        Schema::create('soru_sonuclari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gorev_id')->constrained('gorevler_yks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('cozuldu_soru');
            $table->integer('dogru');
            $table->integer('yanlis');
            $table->date('tarih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soru_sonuclari');
    }
};
