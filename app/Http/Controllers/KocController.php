<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Gorev;
use App\Models\Mesaj;
use App\Models\Hedef;
use App\Models\GorevYks;
use App\Models\SoruSonucu;
use Carbon\Carbon;
use App\Models\HaftalikHedef;

class KocController extends Controller
{
    // Main panel page - redirects to students list
    public function panel()
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        return redirect('/koc/ogrenciler');
    }

    // Students list page
    public function ogrenciler()
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $kocId = Auth::id();
        $ogrenciler = User::where('rol', 'ogrenci')
            ->where('coach_id', $kocId)
            ->get();
        
        // Calculate success rate based on correct/incorrect answer ratio for each student
        foreach ($ogrenciler as $ogrenci) {
            // Get all YKS tasks for the student
            $gorevlerYks = GorevYks::where('user_id', $ogrenci->id)
                ->where('coach_id', $kocId)
                ->get();
            
            $toplamDogru = 0;
            $toplamYanlis = 0;
            
            // Get the last result for each task
            foreach ($gorevlerYks as $gorev) {
                $sonSonuc = SoruSonucu::where('soru_sonuclari.gorev_id', $gorev->id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                
                if ($sonSonuc) {
                    $toplamDogru += $sonSonuc->dogru;
                    $toplamYanlis += $sonSonuc->yanlis;
                }
            }
            
            // Calculate the success rate
            $toplamCozulen = $toplamDogru + $toplamYanlis;
            
            if ($toplamCozulen > 0) {
                $ogrenci->ortalama_yuzde = round(($toplamDogru / $toplamCozulen) * 100);
            } else {
                $ogrenci->ortalama_yuzde = 0;
            }
        }
        
        return view('koc-ogrenciler', [
            'active_page' => 'ogrenciler',
            'ogrenciler' => $ogrenciler
        ]);
    }

    // Task management page
    public function gorevler()
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $kocId = Auth::id();
        
        // Get YKS tasks assigned by the coach
        $gorevlerYks = GorevYks::where('coach_id', $kocId)
            ->orderBy('olusturma_tarihi', 'desc')
            ->get();
        
        // Get student names for each task
        foreach ($gorevlerYks as $gorev) {
            $ogrenci = User::find($gorev->user_id);
            $gorev->ogrenci_adi = $ogrenci ? $ogrenci->name : 'Bilinmeyen Öğrenci';
            
            // Get the latest result for this task if exists
            $sonSonuc = SoruSonucu::where('soru_sonuclari.gorev_id', $gorev->id)
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($sonSonuc) {
                $gorev->cozulen_soru = $sonSonuc->cozuldu_soru;
                $gorev->dogru_sayisi = $sonSonuc->dogru;
                $gorev->yanlis_sayisi = $sonSonuc->yanlis;
                $gorev->bos_sayisi = $sonSonuc->bos ?? 0;
                $gorev->tamamlama_yuzdesi = min(100, round(($sonSonuc->cozuldu_soru / $gorev->toplam_soru_sayisi) * 100));
            } else {
                $gorev->cozulen_soru = 0;
                $gorev->dogru_sayisi = 0;
                $gorev->yanlis_sayisi = 0;
                $gorev->bos_sayisi = 0;
                $gorev->tamamlama_yuzdesi = 0;
            }
        }
        
        // Get all students for dropdown
        $ogrenciler = User::where('rol', 'ogrenci')
            ->where('coach_id', $kocId)
            ->get();
        
        // Define YKS subjects
        $dersler = [
            'Türkçe', 
            'Matematik', 
            'Fizik', 
            'Kimya', 
            'Biyoloji', 
            'Tarih', 
            'Coğrafya', 
            'Felsefe', 
            'Din'
        ];
        
        return view('koc-gorevler', [
            'active_page' => 'gorevler',
            'gorevler' => $gorevlerYks,
            'ogrenciler' => $ogrenciler,
            'dersler' => $dersler
        ]);
    }

    // Add new task
    public function gorevEkle(Request $request)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $validator = Validator::make($request->all(), [
            'ders_adi' => 'required|string|max:255',
            'toplam_soru_sayisi' => 'required|integer|min:1',
            'ogrenci_id' => 'required|exists:users,id',
            'hedef_tarih' => 'nullable|date|after:today',
        ]);
        
        if ($validator->fails()) {
            return redirect('/koc/gorevler')
                ->withErrors($validator)
                ->withInput();
        }
        
        $gorev = new GorevYks();
        $gorev->ders_adi = $request->ders_adi;
        $gorev->toplam_soru_sayisi = $request->toplam_soru_sayisi;
        $gorev->user_id = $request->ogrenci_id;
        $gorev->coach_id = Auth::id();
        $gorev->hedef_tarih = $request->filled('hedef_tarih') ? $request->hedef_tarih : null;
        $gorev->save();
        
        return redirect('/koc/gorevler')->with('success', 'YKS görevi başarıyla eklendi.');
    }

    // Update task
    public function gorevGuncelle(Request $request, $id)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $validator = Validator::make($request->all(), [
            'gorev_adi' => 'required|string|max:255',
            'aciklama' => 'required|string',
            'tamamlanma_orani' => 'required|integer|min:0|max:100'
        ]);
        
        if ($validator->fails()) {
            return redirect('/koc/gorevler')
                ->withErrors($validator)
                ->withInput();
        }
        
        $gorev = Gorev::find($id);
        
        if (!$gorev || $gorev->coach_id != Auth::id()) {
            return redirect('/koc/gorevler')->with('error', 'Görev bulunamadı veya erişim izniniz yok.');
        }
        
        $gorev->gorev_adi = $request->gorev_adi;
        $gorev->aciklama = $request->aciklama;
        $gorev->tamamlanma_orani = $request->tamamlanma_orani;
        $gorev->save();
        
        return redirect('/koc/gorevler')->with('success', 'Görev başarıyla güncellendi.');
    }

    // Delete task
    public function gorevSil($id)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $gorev = Gorev::find($id);
        
        if (!$gorev || $gorev->coach_id != Auth::id()) {
            return redirect('/koc/gorevler')->with('error', 'Görev bulunamadı veya erişim izniniz yok.');
        }
        
        $gorev->delete();
        
        return redirect('/koc/gorevler')->with('success', 'Görev başarıyla silindi.');
    }

    // Delete YKS task
    public function gorevYksSil($id)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $gorev = GorevYks::find($id);
        
        if (!$gorev || $gorev->coach_id != Auth::id()) {
            return redirect('/koc/gorevler')->with('error', 'YKS görevi bulunamadı veya erişim izniniz yok.');
        }
        
        // Delete related results first (optional, can be handled by cascade)
        SoruSonucu::where('gorev_id', $id)->delete();
        
        // Delete the task
        $gorev->delete();
        
        return redirect('/koc/gorevler')->with('success', 'YKS görevi başarıyla silindi.');
    }

    // Messages page
    public function mesajlar()
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $kocId = Auth::id();
        $ogrenciler = User::where('rol', 'ogrenci')
            ->where('coach_id', $kocId)
            ->get();
        
        // Get selected student or first in the list
        $seciliOgrenciId = request('ogrenci_id');
        if (!$seciliOgrenciId && count($ogrenciler) > 0) {
            $seciliOgrenciId = $ogrenciler[0]->id;
        }
        
        // Get messages with selected student
        $mesajlar = [];
        if ($seciliOgrenciId) {
            $mesajlar = Mesaj::where(function($query) use ($kocId, $seciliOgrenciId) {
                    $query->where('gonderen_id', $kocId)
                        ->where('alici_id', $seciliOgrenciId);
                })
                ->orWhere(function($query) use ($kocId, $seciliOgrenciId) {
                    $query->where('gonderen_id', $seciliOgrenciId)
                        ->where('alici_id', $kocId);
                })
                ->orderBy('tarih', 'asc')
                ->get();
        }
        
        // Get selected student info
        $seciliOgrenci = null;
        if ($seciliOgrenciId) {
            $seciliOgrenci = User::find($seciliOgrenciId);
        }
        
        return view('koc-mesajlar', [
            'active_page' => 'mesajlar',
            'ogrenciler' => $ogrenciler,
            'seciliOgrenci' => $seciliOgrenci,
            'mesajlar' => $mesajlar
        ]);
    }
    
    /**
     * Return messages in JSON format for real-time updates
     */
    public function mesajlarVeri(Request $request)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $kocId = Auth::id();
        
        // Get selected student
        $ogrenciId = $request->query('ogrenci_id');
        if (!$ogrenciId) {
            return response()->json(['error' => 'Student ID is required'], 400);
        }
        
        // Verify that the student belongs to this coach
        $ogrenci = User::where('id', $ogrenciId)
            ->where('rol', 'ogrenci')
            ->where('coach_id', $kocId)
            ->first();
            
        if (!$ogrenci) {
            return response()->json(['error' => 'Student not found'], 404);
        }
        
        // Get messages with this student
        $mesajlar = Mesaj::where(function($query) use ($kocId, $ogrenciId) {
                $query->where('gonderen_id', $kocId)
                    ->where('alici_id', $ogrenciId);
            })
            ->orWhere(function($query) use ($kocId, $ogrenciId) {
                $query->where('gonderen_id', $ogrenciId)
                    ->where('alici_id', $kocId);
            })
            ->with('gonderen')
            ->orderBy('tarih', 'asc')
            ->get();
        
        // Format messages for the frontend
        $formattedMessages = $mesajlar->map(function($mesaj) use ($kocId) {
            $isSent = $mesaj->gonderen_id === $kocId;
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

    // Send message
    public function mesajGonder(Request $request)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $validator = Validator::make($request->all(), [
            'alici_id' => 'required|exists:users,id',
            'mesaj' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $mesaj = new Mesaj();
        $mesaj->gonderen_id = Auth::id();
        $mesaj->alici_id = $request->alici_id;
        $mesaj->mesaj = $request->mesaj;
        $mesaj->tarih = now();
        $mesaj->save();
        
        return redirect('/koc/mesajlar?ogrenci_id=' . $request->alici_id)
            ->with('success', 'Mesaj başarıyla gönderildi.');
    }

    // Statistics page
    public function istatistik()
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $kocId = Auth::id();
        $ogrenciler = User::where('rol', 'ogrenci')
            ->where('coach_id', $kocId)
            ->get();
        
        // Calculate total statistics
        $toplam_ogrenci = count($ogrenciler);
        $toplam_gorev = GorevYks::where('coach_id', $kocId)->count();
        
        // Calculate average correct answer ratio
        $toplam_dogru = 0;
        $toplam_soru = 0;
        $en_basarili_ogrenci = null;
        $en_yuksek_basari = 0;
        
        // Get subject-based statistics
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
        
        // Initialize arrays for storing performance data
        $ders_dogru_oranlari = [];
        
        // First get all students assigned to this coach
        $ogrenciIds = $ogrenciler->pluck('id')->toArray();
        
        // Process performance data for each subject
        foreach ($dersler as $ders) {
            // Try to extract the base subject name (without TYT/AYT prefix)
            $dersAdi = explode(' ', $ders);
            $baseDersName = isset($dersAdi[1]) ? $dersAdi[1] : $ders;
            
            // Get all results for this specific subject
            $ders_sonuclari = DB::table('soru_sonuclari')
                ->join('gorevler_yks', 'soru_sonuclari.gorev_id', '=', 'gorevler_yks.id')
                ->whereIn('soru_sonuclari.user_id', $ogrenciIds)
                ->where(function($query) use ($ders, $baseDersName) {
                    $query->where('gorevler_yks.ders_adi', $ders)
                          ->orWhere('gorevler_yks.ders_adi', $baseDersName)
                          ->orWhere('gorevler_yks.ders_adi', 'LIKE', "%{$baseDersName}%");
                })
                ->select(
                    DB::raw('SUM(soru_sonuclari.dogru) as toplam_dogru'),
                    DB::raw('SUM(soru_sonuclari.cozuldu_soru) as toplam_soru')
                )
                ->first();
            
            $ders_dogru = $ders_sonuclari->toplam_dogru ?? 0;
            $ders_soru = $ders_sonuclari->toplam_soru ?? 0;
            
            // Calculate success rate and store in the array
            $ders_dogru_oranlari[] = $ders_soru > 0 ? round(($ders_dogru / $ders_soru) * 100, 1) : 0;
        }
        
        // Calculate student performance
        foreach ($ogrenciler as $ogrenci) {
            $ogrenci_sonuclari = DB::table('soru_sonuclari')
                ->join('gorevler_yks', 'soru_sonuclari.gorev_id', '=', 'gorevler_yks.id')
                ->where('gorevler_yks.coach_id', $kocId)
                ->where('soru_sonuclari.user_id', $ogrenci->id)
                ->select(
                    DB::raw('SUM(soru_sonuclari.dogru) as toplam_dogru'),
                    DB::raw('SUM(soru_sonuclari.cozuldu_soru) as toplam_soru')
                )
                ->first();
            
            $ogrenci_dogru = $ogrenci_sonuclari->toplam_dogru ?? 0;
            $ogrenci_soru = $ogrenci_sonuclari->toplam_soru ?? 0;
            
            $toplam_dogru += $ogrenci_dogru;
            $toplam_soru += $ogrenci_soru;
            
            if ($ogrenci_soru > 0) {
                $basari_yuzdesi = round(($ogrenci_dogru / $ogrenci_soru) * 100);
                
                if ($basari_yuzdesi > $en_yuksek_basari) {
                    $en_yuksek_basari = $basari_yuzdesi;
                    $en_basarili_ogrenci = (object)[
                        'name' => $ogrenci->name,
                        'toplam_dogru' => $ogrenci_dogru,
                        'toplam_soru' => $ogrenci_soru,
                        'basari_yuzdesi' => $basari_yuzdesi,
                        'profile_photo' => $ogrenci->profile_photo
                    ];
                }
            }
        }
        
        $ortalama_dogru_orani = $toplam_soru > 0 ? round(($toplam_dogru / $toplam_soru) * 100) : 0;
        
        // Get weekly progress data
        $haftalar = [];
        $haftalik_tamamlanan = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $tarih = Carbon::now()->subWeeks($i);
            $hafta_baslangic = $tarih->startOfWeek();
            $hafta_bitis = $tarih->endOfWeek();
            
            $hafta_tamamlanan = GorevYks::where('coach_id', $kocId)
                ->where('tamamlandi', true)
                ->whereBetween('tamamlanma_tarihi', [$hafta_baslangic, $hafta_bitis])
                ->count();
            
            $haftalar[] = $hafta_baslangic->format('d.m');
            $haftalik_tamamlanan[] = $hafta_tamamlanan;
        }
        
        // Get student comparison data
        $ogrenci_ders_performanslari = [];
        foreach ($ogrenciler as $ogrenci) {
            $performans = [];
            foreach ($dersler as $ders) {
                $ders_sonuclari = DB::table('soru_sonuclari')
                    ->join('gorevler_yks', 'soru_sonuclari.gorev_id', '=', 'gorevler_yks.id')
                    ->where('gorevler_yks.coach_id', $kocId)
                    ->where('gorevler_yks.ders_adi', $ders)
                    ->where('soru_sonuclari.user_id', $ogrenci->id)
                    ->select(
                        DB::raw('SUM(soru_sonuclari.dogru) as toplam_dogru'),
                        DB::raw('SUM(soru_sonuclari.cozuldu_soru) as toplam_soru')
                    )
                    ->first();
                
                $ders_dogru = $ders_sonuclari->toplam_dogru ?? 0;
                $ders_soru = $ders_sonuclari->toplam_soru ?? 0;
                
                $performans[] = $ders_soru > 0 ? round(($ders_dogru / $ders_soru) * 100) : 0;
            }
            
            $ogrenci_ders_performanslari[] = [
                'label' => $ogrenci->name,
                'data' => $performans,
                'backgroundColor' => 'rgba(139, 107, 78, 0.2)',
                'borderColor' => '#8B6B4E',
                'borderWidth' => 1
            ];
        }
        
        return view('koc-istatistik', [
            'active_page' => 'istatistik',
            'toplam_ogrenci' => $toplam_ogrenci,
            'toplam_gorev' => $toplam_gorev,
            'ortalama_dogru_orani' => $ortalama_dogru_orani,
            'en_basarili_ogrenci' => $en_basarili_ogrenci,
            'dersler' => $dersler,
            'ders_dogru_oranlari' => $ders_dogru_oranlari,
            'haftalar' => $haftalar,
            'haftalik_tamamlanan' => $haftalik_tamamlanan,
            'ogrenci_ders_performanslari' => $ogrenci_ders_performanslari
        ]);
    }

    // Profile page
    public function profil()
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        return view('koc-profil', [
            'active_page' => 'profil',
            'user' => Auth::user()
        ]);
    }

    /**
     * Display tasks for a specific student
     */
    public function ogrenciGorevler($id)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $kocId = Auth::id();
        
        // Get the student and ensure they belong to this coach
        $ogrenci = User::where('id', $id)
            ->where('rol', 'ogrenci')
            ->where('coach_id', $kocId)
            ->first();
            
        if (!$ogrenci) {
            return redirect('/koc/ogrenciler')->with('error', 'Bu öğrenciyi görüntüleme yetkiniz bulunmuyor veya öğrenci bulunamadı.');
        }
        
        // Get all YKS tasks for this student
        $gorevler = GorevYks::where('user_id', $ogrenci->id)
            ->where('coach_id', $kocId)
            ->orderBy('olusturma_tarihi', 'desc')
            ->get();
            
        // For each task, get the latest result
        foreach ($gorevler as $gorev) {
            // Get the latest result for this task
            $sonSonuc = SoruSonucu::where('gorev_id', $gorev->id)
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($sonSonuc) {
                $gorev->cozulen_soru = $sonSonuc->cozuldu_soru;
                $gorev->dogru = $sonSonuc->dogru;
                $gorev->yanlis = $sonSonuc->yanlis;
                
                // Determine task status
                if ($sonSonuc->cozuldu_soru == 0) {
                    $gorev->durum = 'Başlamadı';
                } elseif ($sonSonuc->cozuldu_soru < $gorev->toplam_soru_sayisi) {
                    $gorev->durum = 'Devam Ediyor';
                } else {
                    $gorev->durum = 'Tamamlandı';
                }
            } else {
                $gorev->cozulen_soru = 0;
                $gorev->dogru = 0;
                $gorev->yanlis = 0;
                $gorev->durum = 'Başlamadı';
            }
        }
        
        return view('koc-ogrenci-gorevler', [
            'active_page' => 'ogrenciler',
            'ogrenci' => $ogrenci,
            'gorevler' => $gorevler
        ]);
    }

    // Update profile
    public function profilGuncelle(Request $request)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
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
            
            return redirect('/koc/profil')->with('success', 'Profil fotoğrafınız başarıyla güncellendi.');
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        if ($validator->fails()) {
            return redirect('/koc/profil')
                ->withErrors($validator)
                ->withInput();
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $filename = time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/profile_photos'), $filename);
            $user->profile_photo = 'uploads/profile_photos/' . $filename;
        }
        
        $user->save();
        
        return redirect('/koc/profil')->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    /**
     * Store a new weekly goal
     */
    public function haftalikHedefEkle(Request $request)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        // Handle the case where request is JSON
        $data = $request->json()->all();
        if (!empty($data)) {
            $request->merge($data);
        }
        
        $validator = Validator::make($request->all(), [
            'gun' => 'required|string|in:Pazartesi,Salı,Çarşamba,Perşembe,Cuma,Cumartesi,Pazar',
            'ders_adi' => 'required|string|max:255',
            'hedef_soru' => 'required|integer|min:1',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
        
        $hedef = new HaftalikHedef();
        $hedef->coach_id = Auth::id();
        $hedef->gun = $request->gun;
        $hedef->ders_adi = $request->ders_adi;
        $hedef->hedef_soru = $request->hedef_soru;
        $hedef->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Haftalık hedef başarıyla eklendi.',
            'hedef' => $hedef
        ]);
    }
    
    /**
     * Get weekly goals by day
     */
    public function haftalikHedefler($gun)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $hedefler = HaftalikHedef::where('coach_id', Auth::id())
            ->where('gun', $gun)
            ->get();
            
        return response()->json([
            'status' => 'success',
            'hedefler' => $hedefler
        ]);
    }
    
    /**
     * Delete a weekly goal
     */
    public function haftalikHedefSil($id)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        // Handle the case where request is JSON
        $data = request()->json()->all();
        if (!empty($data)) {
            request()->merge($data);
        }
        
        $hedef = HaftalikHedef::find($id);
        
        if (!$hedef || $hedef->coach_id != Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hedef bulunamadı veya silmeye yetkiniz yok.'
            ]);
        }
        
        $hedef->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Haftalık hedef başarıyla silindi.'
        ]);
    }

    /**
     * Display pending task results for approval
     */
    public function onayBekleyenSonuclar()
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $kocId = Auth::id();
        
        // Get all pending results from students assigned to this coach
        $bekleyenSonuclar = DB::table('soru_sonuclari')
            ->join('gorevler_yks', 'soru_sonuclari.gorev_id', '=', 'gorevler_yks.id')
            ->join('users', 'soru_sonuclari.user_id', '=', 'users.id')
            ->select(
                'soru_sonuclari.*',
                'users.name as ogrenci_adi',
                'gorevler_yks.ders_adi',
                'gorevler_yks.toplam_soru_sayisi'
            )
            ->where('gorevler_yks.coach_id', $kocId)
            ->where('soru_sonuclari.onay_durumu', 'beklemede')
            ->orderBy('soru_sonuclari.created_at', 'desc')
            ->get();
        
        return view('koc-bekleyen-sonuclar', [
            'active_page' => 'bekleyen_sonuclar',
            'bekleyenSonuclar' => $bekleyenSonuclar
        ]);
    }
    
    /**
     * Approve or reject a task result
     */
    public function sonucOnayla(Request $request, $id)
    {
        // Check if user is logged in and has the coach role
        if (!Auth::check() || Auth::user()->rol !== 'koc') {
            return redirect()->route('login');
        }
        
        $validator = Validator::make($request->all(), [
            'onay_durumu' => 'required|in:onaylandi,reddedildi',
            'not' => 'nullable|string|max:1000',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $kocId = Auth::id();
        
        // Find the result and check if it belongs to a student assigned to this coach
        $sonuc = SoruSonucu::findOrFail($id);
        $gorev = GorevYks::findOrFail($sonuc->gorev_id);
        
        if ($gorev->coach_id != $kocId) {
            return redirect('/koc/bekleyen-sonuclar')
                ->with('error', 'Bu sonuç sizin öğrencinize ait değil.');
        }
        
        // Update the result status
        $sonuc->onay_durumu = $request->onay_durumu;
        $sonuc->onay_tarihi = now();
        $sonuc->not = $request->not;
        $sonuc->save();
        
        // Check if task should be marked as complete
        if ($request->onay_durumu === 'onaylandi' && $sonuc->cozuldu_soru >= $gorev->toplam_soru_sayisi) {
            $gorev->tamamlandi = true;
            $gorev->tamamlanma_tarihi = now();
            $gorev->save();
        }
        
        return redirect('/koc/bekleyen-sonuclar')
            ->with('success', 'Sonuç başarıyla ' . ($request->onay_durumu === 'onaylandi' ? 'onaylandı' : 'reddedildi') . '.');
    }
} 