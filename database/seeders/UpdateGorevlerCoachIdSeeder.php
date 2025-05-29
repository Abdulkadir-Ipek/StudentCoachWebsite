<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Gorev;
use Illuminate\Support\Facades\DB;

class UpdateGorevlerCoachIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Koç kullanıcısını bul veya oluştur
        $koc = User::where('rol', 'koc')->first();
        
        if (!$koc) {
            $this->command->info('Koç bulunamadı! Test koçu otomatik oluşturuluyor...');
            
            $koc = User::create([
                'name' => 'Test Koç',
                'email' => 'koc@example.com',
                'password' => bcrypt('password'),
                'rol' => 'koc',
            ]);
        }
        
        // Tüm öğrencileri bul ve koça ata
        $ogrenciler = User::where('rol', 'ogrenci')->get();
        
        if ($ogrenciler->count() == 0) {
            $this->command->info('Öğrenci bulunamadı! Test öğrencisi oluşturuluyor...');
            
            $ogrenci = User::create([
                'name' => 'Test Öğrenci',
                'email' => 'ogrenci@example.com',
                'password' => bcrypt('password'),
                'rol' => 'ogrenci',
                'coach_id' => $koc->id,
            ]);
            
            // Test görevi oluştur
            Gorev::create([
                'gorev_adi' => 'Test Görevi',
                'aciklama' => 'Bu bir test görevidir',
                'user_id' => $ogrenci->id,
                'coach_id' => $koc->id,
                'tamamlanma_orani' => 0,
                'tarih' => now(),
            ]);
            
            $this->command->info('Test öğrencisi ve test görevi oluşturuldu!');
        } else {
            // Tüm öğrencileri koça ata
            $assignedCount = 0;
            foreach ($ogrenciler as $ogrenci) {
                if (!$ogrenci->coach_id) {
                    $ogrenci->coach_id = $koc->id;
                    $ogrenci->save();
                    $assignedCount++;
                }
            }
            
            if ($assignedCount > 0) {
                $this->command->info("Toplam {$assignedCount} öğrenci koça atandı.");
            }
        }
        
        // Öğrencilere ait tüm görevleri koça ata
        $ogrenciIdleri = User::where('rol', 'ogrenci')->pluck('id')->toArray();
        
        $updatedCount = Gorev::whereIn('user_id', $ogrenciIdleri)
            ->whereNull('coach_id')
            ->update(['coach_id' => $koc->id]);
        
        if ($updatedCount > 0) {
            $this->command->info("Toplam {$updatedCount} görev koça atandı.");
        } else {
            $this->command->info("Atanacak görev bulunamadı. Tüm görevler zaten bir koça atanmış.");
        }
    }
}
