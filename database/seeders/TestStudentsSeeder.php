<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\GorevYks;
use App\Models\SoruSonucu;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TestStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a coach ID or create a coach if none exists
        $koc = User::where('rol', 'koc')->first();
        
        if (!$koc) {
            $koc = User::create([
                'name' => 'Ahmet Öğretmen',
                'email' => 'ahmet.ogretmen@example.com',
                'password' => Hash::make('password'),
                'rol' => 'koc',
            ]);
        }
        
        // Available subjects
        $dersler = [
            'TYT Türkçe',
            'TYT Matematik',
            'TYT Tarih',
            'TYT Coğrafya',
            'TYT Din',
            'TYT Felsefe',
            'TYT Fizik',
            'TYT Kimya',
            'TYT Biyoloji',
            'AYT Matematik',
            'AYT Fizik',
            'AYT Kimya',
            'AYT Biyoloji',
            'AYT Edebiyat',
            'AYT Tarih',
            'AYT Coğrafya',
            'AYT Felsefe Grubu'
        ];
        
        // Student information
        $ogrenciler = [
            [
                'name' => 'Zeynep Yılmaz',
                'alan' => 'sayısal'
            ],
            [
                'name' => 'Mustafa Demir',
                'alan' => 'sayısal'
            ],
            [
                'name' => 'Elif Çelik',
                'alan' => 'eşit'
            ],
            [
                'name' => 'Burak Kaya',
                'alan' => 'sözel'
            ],
            [
                'name' => 'Ayşe Öztürk',
                'alan' => 'sayısal'
            ],
            [
                'name' => 'Ahmet Şahin',
                'alan' => 'sayısal'
            ],
            [
                'name' => 'Merve Yıldız',
                'alan' => 'sözel'
            ],
            [
                'name' => 'Emre Aydın',
                'alan' => 'eşit'
            ],
            [
                'name' => 'Zehra Koç',
                'alan' => 'sayısal'
            ],
            [
                'name' => 'Onur Aksoy',
                'alan' => 'sözel'
            ],
            [
                'name' => 'Selin Arslan',
                'alan' => 'eşit'
            ],
            [
                'name' => 'Kerem Güneş',
                'alan' => 'sayısal'
            ],
            [
                'name' => 'Deniz Çetin',
                'alan' => 'eşit'
            ],
            [
                'name' => 'İrem Doğan',
                'alan' => 'sözel'
            ],
            [
                'name' => 'Mehmet Yalçın',
                'alan' => 'sayısal'
            ],
        ];
        
        // Create students
        $createdStudents = [];
        
        foreach ($ogrenciler as $ogrenci) {
            // Generate a unique email using the name and a random string
            $emailName = Str::slug(mb_strtolower($ogrenci['name']), '.');
            $uniqueEmail = $emailName . '.' . Str::random(5) . '@example.com';
            
            $user = User::create([
                'name' => $ogrenci['name'],
                'email' => $uniqueEmail,
                'password' => Hash::make('password'),
                'rol' => 'ogrenci',
                'coach_id' => $koc->id,
                'alan' => $ogrenci['alan'],
            ]);
            
            $createdStudents[] = $user;
        }
        
        // Create tasks and question results for each student
        foreach ($createdStudents as $student) {
            // Assign subjects based on student's field
            $studentSubjects = [];
            
            switch ($student->alan) {
                case 'sayısal':
                    $studentSubjects = [
                        'TYT Türkçe', 'TYT Matematik', 'TYT Fizik', 'TYT Kimya', 'TYT Biyoloji',
                        'AYT Matematik', 'AYT Fizik', 'AYT Kimya', 'AYT Biyoloji'
                    ];
                    break;
                case 'sözel':
                    $studentSubjects = [
                        'TYT Türkçe', 'TYT Matematik', 'TYT Tarih', 'TYT Coğrafya', 'TYT Felsefe',
                        'AYT Edebiyat', 'AYT Tarih', 'AYT Coğrafya', 'AYT Felsefe Grubu'
                    ];
                    break;
                case 'eşit':
                    $studentSubjects = [
                        'TYT Türkçe', 'TYT Matematik', 'TYT Tarih', 'TYT Coğrafya', 'TYT Fizik', 'TYT Kimya',
                        'AYT Matematik', 'AYT Edebiyat', 'AYT Tarih', 'AYT Coğrafya'
                    ];
                    break;
            }
            
            // Create 5-8 tasks for each student
            $taskCount = rand(5, 8);
            for ($i = 0; $i < $taskCount; $i++) {
                $subject = $studentSubjects[array_rand($studentSubjects)];
                $totalQuestions = rand(30, 100);
                
                $task = GorevYks::create([
                    'user_id' => $student->id,
                    'coach_id' => $koc->id,
                    'ders_adi' => $subject,
                    'toplam_soru_sayisi' => $totalQuestions,
                    'hedef_tarih' => Carbon::now()->addDays(rand(1, 30)),
                    'olusturma_tarihi' => Carbon::now()->subDays(rand(1, 15))
                ]);
                
                // Create 1-5 result entries for each task
                $resultCount = rand(1, 5);
                for ($j = 0; $j < $resultCount; $j++) {
                    $solvedQuestions = rand(5, $totalQuestions);
                    $correct = rand(0, $solvedQuestions);
                    $wrong = $solvedQuestions - $correct;
                    
                    SoruSonucu::create([
                        'user_id' => $student->id,
                        'gorev_id' => $task->id,
                        'ders_adi' => $subject,
                        'cozuldu_soru' => $solvedQuestions,
                        'dogru' => $correct,
                        'yanlis' => $wrong,
                        'tarih' => Carbon::now()->subDays(rand(0, 14))
                    ]);
                }
            }
            
            // Create one additional task for each subject the student studies
            foreach ($studentSubjects as $subject) {
                // Create a new task
                $totalQuestions = rand(30, 100);
                $task = GorevYks::create([
                    'user_id' => $student->id,
                    'coach_id' => $koc->id,
                    'ders_adi' => $subject,
                    'toplam_soru_sayisi' => $totalQuestions,
                    'hedef_tarih' => Carbon::now()->addDays(rand(1, 30)),
                    'olusturma_tarihi' => Carbon::now()->subDays(rand(1, 15))
                ]);
                
                // Add 1-3 results for this task
                $resultCount = rand(1, 3);
                for ($j = 0; $j < $resultCount; $j++) {
                    $solvedQuestions = rand(5, $totalQuestions);
                    $correct = rand(0, $solvedQuestions);
                    $wrong = $solvedQuestions - $correct;
                    
                    SoruSonucu::create([
                        'user_id' => $student->id,
                        'gorev_id' => $task->id,
                        'ders_adi' => $subject,
                        'cozuldu_soru' => $solvedQuestions,
                        'dogru' => $correct,
                        'yanlis' => $wrong,
                        'tarih' => Carbon::now()->subDays(rand(0, 30))
                    ]);
                }
            }
        }
        
        $this->command->info('Test students with their question solutions have been created successfully!');
    }
} 