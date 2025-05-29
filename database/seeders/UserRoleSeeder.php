<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Koç kullanıcısı oluştur
        $koc = User::create([
            'name' => 'Test Koç',
            'email' => 'koc@example.com',
            'password' => Hash::make('password'),
            'rol' => 'koc',
        ]);
        
        // Test öğrenci kullanıcısı oluştur
        $ogrenci = User::create([
            'name' => 'Test Öğrenci',
            'email' => 'ogrenci@example.com',
            'password' => Hash::make('password'),
            'rol' => 'ogrenci',
            'coach_id' => $koc->id
        ]);
        
        // Diğer öğrencilerin coach_id'lerini güncelle (varsa)
        User::where('rol', 'ogrenci')
            ->where('id', '!=', $ogrenci->id)
            ->whereNull('coach_id')
            ->update(['coach_id' => $koc->id]);
            
        $this->command->info('Koç ve öğrenci kullanıcıları başarıyla oluşturuldu!');
    }
}
