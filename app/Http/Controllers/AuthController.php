<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gorev;
use App\Models\Mesaj;
use App\Models\Hedef;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\GorevYks;
use App\Models\SoruSonucu;
use Illuminate\Support\Facades\Validator;
use App\Models\HaftalikHedef;
use App\Models\HedefTamamlama;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'ogrenci', // Default role for newly registered users
        ]);

        // Send verification email
        $user->sendEmailVerificationNotification();

        // Redirect to login page with email verification notice
        return redirect()->route('login')->withErrors([
            'email' => 'E-posta adresiniz doğrulanmamış. Lütfen e-posta kutunuzu kontrol edin veya yeni bir doğrulama bağlantısı isteyin.',
        ])->with('verify_email', true)->with('registered_email', $request->email);
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Check if email is verified
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'E-posta adresiniz doğrulanmamış. Lütfen e-posta kutunuzu kontrol edin veya yeni bir doğrulama bağlantısı isteyin.',
                ])->with('verify_email', true);
            }
            
            // Redirect based on role
            if (Auth::user()->rol === 'koc') {
                return redirect()->intended('/koc/panel');
            }
            
            return redirect()->intended('/ogrenci-panel');
        }

        return back()->withErrors([
            'email' => 'Verilen kimlik bilgileri kayıtlarımızla eşleşmiyor.',
        ]);
    }

    public function ogrenciPanel()
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Check if user has selected a coach
        if (!$user->coach_id) {
            // Get list of coaches for selection
            $koclar = User::where('rol', 'koc')->get();
            
            return view('ogrenci-panel', [
                'user' => $user,
                'koclar' => $koclar,
                'active_page' => 'gorevler',
                'coach_id_null' => true
            ]);
        }
        
        // Get latest message for the student
        $son_mesaj = Mesaj::where(function($query) use ($user) {
                $query->where('alici_id', $user->id)
                      ->orWhere('gonderen_id', $user->id);
            })
            ->with('gonderen')
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Get tasks for today
        $today = Carbon::now()->locale('tr')->isoFormat('dddd');
        
        // Get YKS tasks with completion statistics
        $gorevlerYks = GorevYks::where('gorevler_yks.user_id', $user->id)
            ->select(
                'gorevler_yks.id',
                'gorevler_yks.ders_adi',
                'gorevler_yks.toplam_soru_sayisi',
                'gorevler_yks.hedef_tarih',
                'gorevler_yks.tamamlandi',
                DB::raw('(SELECT SUM(ss.cozuldu_soru) FROM soru_sonuclari ss WHERE ss.gorev_id = gorevler_yks.id AND ss.onay_durumu = "onaylandi") as cozulen_soru'),
                DB::raw('(SELECT SUM(ss.dogru) FROM soru_sonuclari ss WHERE ss.gorev_id = gorevler_yks.id AND ss.onay_durumu = "onaylandi") as dogru_sayisi'),
                DB::raw('(SELECT SUM(ss.yanlis) FROM soru_sonuclari ss WHERE ss.gorev_id = gorevler_yks.id AND ss.onay_durumu = "onaylandi") as yanlis_sayisi'),
                DB::raw('(SELECT SUM(ss.bos) FROM soru_sonuclari ss WHERE ss.gorev_id = gorevler_yks.id AND ss.onay_durumu = "onaylandi") as bos_sayisi'),
                DB::raw('ROUND(IFNULL((SELECT SUM(ss.cozuldu_soru) FROM soru_sonuclari ss WHERE ss.gorev_id = gorevler_yks.id AND ss.onay_durumu = "onaylandi") / gorevler_yks.toplam_soru_sayisi * 100, 0)) as tamamlama_yuzdesi')
            )
            ->groupBy('gorevler_yks.id', 'gorevler_yks.ders_adi', 'gorevler_yks.toplam_soru_sayisi', 'gorevler_yks.hedef_tarih', 'gorevler_yks.tamamlandi')
            ->get();
            
        // Get today's weekly goals
        $bugunHedefler = HaftalikHedef::where('coach_id', $user->coach_id)
            ->where('gun', $today)
            ->get();
            
        // Ensure Matematik and Türkçe goals exist
        $matematikHedef = $bugunHedefler->where('ders_adi', 'Matematik')->first();
        if (!$matematikHedef) {
            $matematikHedef = new HaftalikHedef();
            $matematikHedef->id = 1; // Use ID 1 for Matematik
            $matematikHedef->coach_id = $user->coach_id;
            $matematikHedef->gun = $today;
            $matematikHedef->ders_adi = 'Matematik';
            $matematikHedef->hedef_soru = 50;
            $matematikHedef->exists = true; // Prevent trying to save this to database
            $bugunHedefler->push($matematikHedef);
        }
        
        $turkceHedef = $bugunHedefler->where('ders_adi', 'Türkçe')->first();
        if (!$turkceHedef) {
            // Check if there's a real Türkçe goal in the database
            $dbTurkceHedef = HaftalikHedef::where('coach_id', $user->coach_id)
                ->where('ders_adi', 'Türkçe')
                ->first();
                
            if ($dbTurkceHedef) {
                $turkceHedef = $dbTurkceHedef;
            } else {
                // Create a temporary Türkçe goal
                $turkceHedef = new HaftalikHedef();
                $turkceHedef->id = 3; // Use ID 3 for Türkçe
                $turkceHedef->coach_id = $user->coach_id;
                $turkceHedef->gun = $today;
                $turkceHedef->ders_adi = 'Türkçe';
                $turkceHedef->hedef_soru = 20;
                $turkceHedef->exists = true; // Prevent trying to save this to database
                $bugunHedefler->push($turkceHedef);
            }
        }
        
        // Get pending results for the student
        $bekleyenSonuclar = SoruSonucu::where('soru_sonuclari.user_id', $user->id)
            ->where('onay_durumu', 'beklemede')
            ->join('gorevler_yks', 'soru_sonuclari.gorev_id', '=', 'gorevler_yks.id')
            ->select('soru_sonuclari.*', 'gorevler_yks.ders_adi')
            ->orderBy('soru_sonuclari.created_at', 'desc')
            ->get();
        
        // Get recently approved or rejected results
        $sonIslemler = SoruSonucu::where('soru_sonuclari.user_id', $user->id)
            ->whereIn('onay_durumu', ['onaylandi', 'reddedildi'])
            ->join('gorevler_yks', 'soru_sonuclari.gorev_id', '=', 'gorevler_yks.id')
            ->select('soru_sonuclari.*', 'gorevler_yks.ders_adi')
            ->orderBy('soru_sonuclari.onay_tarihi', 'desc')
            ->limit(5)
            ->get();
            
        // Check if the goals have been completed today
        foreach ($bugunHedefler as $hedef) {
            $tamamlama = HedefTamamlama::where('user_id', $user->id)
                ->where('hedef_id', $hedef->id)
                ->where(function($query) {
                    $query->whereDate('tarih', Carbon::today())
                          ->orWhereNull('tarih')
                          ->whereDate('created_at', Carbon::today());
                })
                ->first();
                
            $hedef->tamamlandi = $tamamlama ? true : false;
        }
            
        return view('ogrenci-panel', [
            'user' => $user,
            'gorevler' => $gorevlerYks,
            'son_mesaj' => $son_mesaj,
            'active_page' => 'gorevler',
            'coach_id_null' => false,
            'bugunHedefler' => $bugunHedefler,
            'bugun' => $today,
            'bekleyenSonuclar' => $bekleyenSonuclar,
            'sonIslemler' => $sonIslemler
        ]);
    }

    /**
     * Handle coach selection for a student
     */
    public function kocSec(Request $request)
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }
        
        $request->validate([
            'coach_id' => 'required|exists:users,id'
        ]);
        
        $user = Auth::user();
        
        // Check if selected user is actually a coach
        $koc = User::where('id', $request->coach_id)
            ->where('rol', 'koc')
            ->first();
            
        if (!$koc) {
            return back()->with('error', 'Geçersiz koç seçimi. Lütfen listeden bir koç seçin.');
        }
        
        // Update student's coach
        $user->coach_id = $koc->id;
        $user->save();
        
        return redirect('/ogrenci-panel')->with('success', 'Koç seçiminiz başarıyla kaydedildi. Artık sistemi kullanmaya başlayabilirsiniz.');
    }

    public function profilim()
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        return view('profilim', [
            'user' => $user,
            'active_page' => 'profilim'
        ]);
    }

    public function profilimGuncelle(Request $request)
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // If this is a photo-only update
        if ($request->has('update_photo_only')) {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            
            if ($request->hasFile('profile_photo')) {
                $photo = $request->file('profile_photo');
                $filename = time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('uploads/profile_photos'), $filename);
                $user->profile_photo = 'uploads/profile_photos/' . $filename;
                $user->save();
            }
            
            return redirect('/profilim')->with('success', 'Profil fotoğrafınız başarıyla güncellendi.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        
        return redirect('/profilim')->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    public function istatistikler()
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Get all YKS results for the student
        $soruSonuclari = SoruSonucu::where('user_id', $user->id)->get();
        
        // Calculate total numbers
        $toplamCozulenSoru = $soruSonuclari->sum('cozuldu_soru');
        $toplamDogru = $soruSonuclari->sum('dogru');
        $toplamYanlis = $soruSonuclari->sum('yanlis');
        $toplamBos = $soruSonuclari->sum('bos');
        
        // Get daily question counts for last 7 days
        $gunler = ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'];
        $gunlukSorular = [];
        
        $simdi = Carbon::now();
        $baslangic = $simdi->copy()->subDays(6);
        
        for ($i = 0; $i < 7; $i++) {
            $tarih = $baslangic->copy()->addDays($i);
            $gun = $gunler[$tarih->dayOfWeek == 0 ? 6 : $tarih->dayOfWeek - 1]; // Convert to 0-6 format
            
            // Sum all entries for this specific day (in case there are multiple entries for different subjects)
            $gunlukCozulen = SoruSonucu::where('soru_sonuclari.user_id', $user->id)
                ->whereDate('tarih', $tarih->toDateString())
                ->sum('cozuldu_soru');
                
            $gunlukSorular[$gun] = $gunlukCozulen;
        }
        
        // Get subject-based statistics
        $dersIstatistikleri = DB::table('soru_sonuclari')
            ->join('gorevler_yks', 'soru_sonuclari.gorev_id', '=', 'gorevler_yks.id')
            ->select('gorevler_yks.ders_adi', 
                DB::raw('SUM(soru_sonuclari.cozuldu_soru) as toplam_cozulen'),
                DB::raw('SUM(soru_sonuclari.dogru) as toplam_dogru'),
                DB::raw('SUM(soru_sonuclari.yanlis) as toplam_yanlis'),
                DB::raw('SUM(soru_sonuclari.bos) as toplam_bos'))
            ->where('soru_sonuclari.user_id', $user->id)
            ->groupBy('gorevler_yks.ders_adi')
            ->get();
        
        return view('istatistikler', [
            'user' => $user,
            'toplamCozulenSoru' => $toplamCozulenSoru,
            'toplamDogru' => $toplamDogru,
            'toplamYanlis' => $toplamYanlis,
            'toplamBos' => $toplamBos,
            'gunlukSorular' => $gunlukSorular,
            'dersIstatistikleri' => $dersIstatistikleri,
            'active_page' => 'istatistikler'
        ]);
    }

    public function dashboard()
    {
        return view('dashboard', ['user' => Auth::user()]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Record the question results for a task
     */
    public function sonucKaydet(Request $request)
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }
        
        $validator = Validator::make($request->all(), [
            'gorev_id' => 'required|exists:gorevler_yks,id',
            'cozuldu_soru' => 'required|integer|min:1',
            'dogru' => 'required|integer|min:0',
            'yanlis' => 'required|integer|min:0',
            'bos' => 'required|integer|min:0',
        ]);
        
        if ($validator->fails()) {
            return redirect('/ogrenci-panel')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Verify that the task belongs to the current user
        $gorev = GorevYks::find($request->gorev_id);
        if (!$gorev || $gorev->user_id != Auth::id()) {
            return redirect('/ogrenci-panel')
                ->with('error', 'Bu göreve erişiminiz yok.');
        }
        
        // Validate that the sum of correct, incorrect and empty answers equals the total
        if ($request->dogru + $request->yanlis + $request->bos != $request->cozuldu_soru) {
            return redirect('/ogrenci-panel')
                ->with('error', 'Doğru, yanlış ve boş sayılarının toplamı, çözülen soru sayısına eşit olmalıdır.')
                ->withInput();
        }
        
        // Validate that the number of solved questions does not exceed the total
        if ($request->cozuldu_soru > $gorev->toplam_soru_sayisi) {
            return redirect('/ogrenci-panel')
                ->with('error', 'Çözülen soru sayısı, toplam soru sayısından fazla olamaz.')
                ->withInput();
        }
        
        // Always create a new record for tracking approval status
        $sonuc = new SoruSonucu();
        $sonuc->gorev_id = $request->gorev_id;
        $sonuc->user_id = Auth::id();
        $sonuc->ders_adi = $gorev->ders_adi; // Set the subject name
        $sonuc->cozuldu_soru = $request->cozuldu_soru;
        $sonuc->dogru = $request->dogru;
        $sonuc->yanlis = $request->yanlis;
        $sonuc->bos = $request->bos;
        $sonuc->tarih = now()->toDateString();
        $sonuc->onay_durumu = 'beklemede'; // Set initial status to pending
        $sonuc->save();
        
        return redirect('/ogrenci-panel')
            ->with('success', 'Soru sonuçlarınız başarıyla gönderildi ve koçunuzun onayını bekliyor.');
    }

    /**
     * Show the messaging page for students
     */
    public function mesajlar()
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Check if student has a coach
        if (!$user->coach_id) {
            return redirect('/ogrenci-panel')
                ->with('error', 'Mesajlaşma özelliğini kullanabilmek için öncelikle bir koç seçmelisiniz.');
        }
        
        // Get the coach information
        $koc = User::find($user->coach_id);
        
        if (!$koc) {
            return redirect('/ogrenci-panel')
                ->with('error', 'Koçunuzun bilgilerine erişilemedi. Lütfen yönetici ile iletişime geçin.');
        }
        
        // Get message history between the student and coach
        $mesajlar = Mesaj::where(function($query) use ($user, $koc) {
                $query->where('gonderen_id', $user->id)
                    ->where('alici_id', $koc->id);
            })
            ->orWhere(function($query) use ($user, $koc) {
                $query->where('gonderen_id', $koc->id)
                    ->where('alici_id', $user->id);
            })
            ->orderBy('tarih', 'asc')
            ->get();
        
        return view('ogrenci-mesajlar', [
            'user' => $user,
            'koc' => $koc,
            'mesajlar' => $mesajlar,
            'active_page' => 'mesajlar'
        ]);
    }
    
    /**
     * Return messages in JSON format for real-time updates
     */
    public function mesajlarVeri()
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        
        // Check if student has a coach
        if (!$user->coach_id) {
            return response()->json(['error' => 'Coach not assigned'], 400);
        }
        
        // Get message history between the student and coach
        $mesajlar = Mesaj::where(function($query) use ($user) {
                $query->where('gonderen_id', $user->id)
                    ->where('alici_id', $user->coach_id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('gonderen_id', $user->coach_id)
                    ->where('alici_id', $user->id);
            })
            ->with('gonderen')
            ->orderBy('tarih', 'asc')
            ->get();
        
        // Format messages for the frontend
        $formattedMessages = $mesajlar->map(function($mesaj) use ($user) {
            $isSent = $mesaj->gonderen_id === $user->id;
            $messageDate = Carbon::parse($mesaj->tarih);
            
            return [
                'id' => $mesaj->id,
                'message' => $mesaj->mesaj,
                'isSent' => $isSent,
                'time' => $messageDate->format('d.m.Y H:i'),
                'sender_name' => $mesaj->gonderen->name,
            ];
        });
        
        return response()->json($formattedMessages);
    }
    
    /**
     * Send a message to the coach
     */
    public function mesajGonder(Request $request)
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Check if student has a coach
        if (!$user->coach_id) {
            return redirect('/ogrenci-panel')
                ->with('error', 'Mesaj gönderebilmek için öncelikle bir koç seçmelisiniz.');
        }
        
        $request->validate([
            'mesaj' => 'required|string|max:1000',
        ]);
        
        // Create and save the message
        $mesaj = new Mesaj();
        $mesaj->gonderen_id = $user->id;
        $mesaj->alici_id = $user->coach_id;
        $mesaj->mesaj = $request->mesaj;
        $mesaj->tarih = now();
        $mesaj->save();
        
        return redirect('/ogrenci/mesajlar')
            ->with('success', 'Mesajınız başarıyla gönderildi.');
    }

    /**
     * Show the forgot password form
     */
    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    /**
     * Send a password reset link to the given user
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Bu e-posta adresi ile kayıtlı bir kullanıcı bulunamadı.'
        ]);

        // Generate a unique token
        $token = bin2hex(random_bytes(32));
        $expiry = now()->addHour();

        // Store the token in the password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now(),
                'expires_at' => $expiry
            ]
        );

        // Get the reset link
        $resetLink = url("/reset-password/{$token}?email=" . urlencode($request->email));

        // Get user
        $user = User::where('email', $request->email)->first();
        
        try {
            // Try Laravel Mail to send email with Mailtrap
            Mail::to($request->email)->send(new \App\Mail\ResetPassword($user->name, $resetLink));
            
            // Redirect back with success message
            return redirect()->route('login')->with('success', 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi. Lütfen gelen kutunuzu kontrol edin.');
        } catch (\Exception $e) {
            // Log the error but don't expose it to user
            \Log::error('E-posta gönderme hatası: ' . $e->getMessage());
            
            // Try direct PHP mail function as fallback
            $subject = "Şifre Sıfırlama Bağlantısı - EduCoach";
            
            $htmlMessage = "
            <html>
            <head>
                <title>Şifre Sıfırlama</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #6C4AB6; color: white; padding: 20px; text-align: center; }
                    .content { padding: 20px; border: 1px solid #ddd; border-top: none; }
                    .button { display: inline-block; background-color: #6C4AB6; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; margin: 20px 0; }
                    .footer { font-size: 12px; color: #777; margin-top: 20px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>EduCoach Şifre Sıfırlama</h1>
                    </div>
                    <div class='content'>
                        <p>Merhaba " . htmlspecialchars($user->name) . ",</p>
                        <p>EduCoach hesabınız için şifre sıfırlama talebinde bulundunuz. Şifrenizi sıfırlamak için aşağıdaki butona tıklayabilirsiniz:</p>
                        <p style='text-align: center;'>
                            <a href='" . $resetLink . "' class='button'>Şifremi Sıfırla</a>
                        </p>
                        <p>Veya aşağıdaki bağlantıyı tarayıcınıza kopyalayabilirsiniz:</p>
                        <p>" . $resetLink . "</p>
                        <p>Bu bağlantı 1 saat boyunca geçerli olacaktır.</p>
                        <p>Eğer şifre sıfırlama talebinde bulunmadıysanız, bu e-postayı görmezden gelebilirsiniz.</p>
                    </div>
                    <div class='footer'>
                        <p>Saygılarımızla,<br>EduCoach Ekibi</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            // Headers for HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: EduCoach <noreply@educoach.com>" . "\r\n";
            
            $mailSent = mail($request->email, $subject, $htmlMessage, $headers);
            
            if ($mailSent) {
                return redirect()->route('login')->with('success', 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi. Lütfen gelen kutunuzu kontrol edin.');
            } else {
                // Fallback to direct link display if both methods fail
                return view('reset-link', [
                    'resetLink' => $resetLink,
                    'email' => $request->email
                ])->with('warning', 'E-posta gönderilirken bir hata oluştu. Lütfen aşağıdaki bağlantıyı kullanın.');
            }
        }
    }

    /**
     * Display the password reset view for the given token
     */
    public function showResetPassword(Request $request, $token)
    {
        return view('reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    /**
     * Reset the given user's password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // Check if the token is valid and not expired
        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Geçersiz veya süresi dolmuş şifre sıfırlama bağlantısı.']);
        }

        // Update the user's password
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Delete the token
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Redirect to login with success message
        return redirect()->route('login')->with('success', 'Şifreniz başarıyla sıfırlandı. Yeni şifrenizle giriş yapabilirsiniz.');
    }

    /**
     * Handle field selection for a student
     */
    public function alanSec(Request $request)
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }
        
        $request->validate([
            'alan' => 'required|in:sayısal,eşit,sözel'
        ]);
        
        $user = Auth::user();
        
        // Update student's field
        $user->alan = $request->alan;
        $user->save();
        
        return redirect('/ogrenci-panel')->with('success', 'Alan seçiminiz başarıyla kaydedildi.');
    }

    /**
     * Display the rankings page for a student
     */
    public function siralama()
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Check if student has selected a field
        if (!$user->alan) {
            return redirect('/ogrenci-panel')
                ->with('error', 'Sıralama sayfasını görüntüleyebilmek için önce alanınızı seçmeniz gerekmektedir.');
        }
        
        // Get other students with the same field
        $ogrenciler = User::where('rol', 'ogrenci')
            ->where('alan', $user->alan)
            ->pluck('id');
            
        // Field title for display
        $alanBaslik = ucfirst($user->alan);
        
        // Initialize data structure for rankings
        $siralamaVerisi = [];
        
        // Define ALL subjects for ranking
        $dersler = [
            'TYT Türkçe', 'TYT Matematik', 'TYT Tarih', 'TYT Coğrafya', 'TYT Din', 'TYT Felsefe',
            'TYT Fizik', 'TYT Kimya', 'TYT Biyoloji',
            'AYT Matematik', 'AYT Fizik', 'AYT Kimya', 'AYT Biyoloji',
            'AYT Edebiyat', 'AYT Tarih', 'AYT Coğrafya', 'AYT Felsefe Grubu'
        ];
        
        // For each subject, calculate rankings
        foreach ($dersler as $ders) {
            // Get solution data for this subject
            $ders_sonuclari = DB::table('soru_sonuclari')
                ->select(
                    'soru_sonuclari.user_id',
                    'users.name',
                    DB::raw('SUM(soru_sonuclari.cozuldu_soru) as toplam'),
                    DB::raw('SUM(soru_sonuclari.dogru) as dogru'),
                    DB::raw('CASE WHEN SUM(soru_sonuclari.cozuldu_soru) > 0 
                        THEN (SUM(soru_sonuclari.dogru) / SUM(soru_sonuclari.cozuldu_soru)) * 100 
                        ELSE 0 END as oran')
                )
                ->join('users', 'soru_sonuclari.user_id', '=', 'users.id')
                ->whereIn('soru_sonuclari.user_id', $ogrenciler)
                ->where('soru_sonuclari.ders_adi', $ders)
                ->groupBy('soru_sonuclari.user_id', 'users.name')
                ->having(DB::raw('SUM(soru_sonuclari.cozuldu_soru)'), '>', 0) // Only include students with solutions
                ->orderByDesc('oran')
                ->get();
            
            // Add to ranking data
            $siralamaVerisi[$ders] = $ders_sonuclari;
        }
        
        return view('ogrenci-siralama', [
            'user' => $user,
            'active_page' => 'siralama',
            'alanBaslik' => $alanBaslik,
            'siralamaVerisi' => $siralamaVerisi
        ]);
    }

    /**
     * Show the email verification notice.
     */
    public function verificationNotice()
    {
        return view('auth.verify-email');
    }

    /**
     * Resend the email verification notification.
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'E-posta adresiniz zaten doğrulanmış. Giriş yapabilirsiniz.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')->with('error', 'Doğrulama bağlantısı geçersiz.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'E-posta adresiniz zaten doğrulanmış. Giriş yapabilirsiniz.');
        }

        $user->markEmailAsVerified();

        return redirect()->route('login')->with('success', 'E-posta adresiniz başarıyla doğrulandı. Şimdi giriş yapabilirsiniz.');
    }
} 