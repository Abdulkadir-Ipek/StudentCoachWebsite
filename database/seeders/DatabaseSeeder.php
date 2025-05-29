<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Gorev;
use App\Models\Mesaj;
use App\Models\Hedef;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a student user
        $ogrenci = User::create([
            'name' => 'Ahmet Yılmaz',
            'email' => 'ahmet@example.com',
            'password' => Hash::make('12345678'),
            'rol' => 'ogrenci',
        ]);
        
        // Create a coach user
        $koc = User::create([
            'name' => 'Ayşe Öğretmen',
            'email' => 'ayse@example.com',
            'password' => Hash::make('12345678'),
            'rol' => 'koc',
        ]);
        
        // Create tasks for the student
        $gorevler = [
            [
                'user_id' => $ogrenci->id,
                'gorev_adi' => 'Görev 1',
                'tamamlanma_orani' => 75,
            ],
            [
                'user_id' => $ogrenci->id,
                'gorev_adi' => 'Görev 2',
                'tamamlanma_orani' => 50,
            ],
            [
                'user_id' => $ogrenci->id,
                'gorev_adi' => 'Görev 3',
                'tamamlanma_orani' => 30,
            ],
            [
                'user_id' => $ogrenci->id,
                'gorev_adi' => 'Görev 4',
                'tamamlanma_orani' => 80,
            ],
        ];
        
        foreach ($gorevler as $gorev) {
            Gorev::create($gorev);
        }
        
        // Create a message from coach to student
        Mesaj::create([
            'gonderen_id' => $koc->id,
            'alici_id' => $ogrenci->id,
            'mesaj' => 'Yarın görüşmeyi unutma!',
            'tarih' => now(),
        ]);
        
        // Create weekly targets for the student
        $gunler = ['Pzt', 'Sal', 'Çar', 'Cm', 'Paz'];
        $yuzde_degerleri = [60, 65, 80, 70, 90];
        
        for ($i = 0; $i < count($gunler); $i++) {
            Hedef::create([
                'user_id' => $ogrenci->id,
                'gun' => $gunler[$i],
                'yuzde' => $yuzde_degerleri[$i],
            ]);
        }
        
        // Call the TestStudentsSeeder to create additional student accounts with question data
        $this->call(TestStudentsSeeder::class);
    }
}
