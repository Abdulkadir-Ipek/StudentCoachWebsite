<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\HedefTamamlama;
use App\Models\HaftalikHedef;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    
    /**
     * Complete a daily goal
     */
    public function hedefTamamla(Request $request)
    {
        // Check if user is logged in and has the student role
        if (!Auth::check() || Auth::user()->rol !== 'ogrenci') {
            return redirect()->route('login');
        }
        
        // Handle the case where request is JSON
        $data = $request->json()->all();
        if (!empty($data) && isset($data['hedef_id'])) {
            $request->merge($data);
        }
        
        $validator = Validator::make($request->all(), [
            'hedef_id' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
        
        $hedefId = $request->hedef_id;
        $userId = Auth::id();
        $coachId = Auth::user()->coach_id;
        $today = Carbon::now()->locale('tr')->isoFormat('dddd');
        
        // Try to find the existing weekly goal
        $hedef = HaftalikHedef::find($hedefId);
        
        // Handle default goals (Matematik ID=1, Türkçe ID=3) if they don't exist in the database
        if (!$hedef && in_array($hedefId, [1, 3])) {
            $dersAdi = ($hedefId == 1) ? 'Matematik' : 'Türkçe';
            $hedefSoru = ($hedefId == 1) ? 50 : 20;
            
            // Check if a goal with this name and coach already exists (maybe added manually)
            $existingByName = HaftalikHedef::where('coach_id', $coachId)->where('ders_adi', $dersAdi)->first();
            
            if ($existingByName) {
                $hedef = $existingByName;
                $hedefId = $hedef->id; // Use the actual ID from DB
            } else {
                try {
                    // Create the default weekly goal if it truly doesn't exist
                    $hedef = new HaftalikHedef();
                    $hedef->id = $hedefId; // Attempt to use the default ID
                    $hedef->coach_id = $coachId;
                    $hedef->gun = $today; 
                    $hedef->ders_adi = $dersAdi;
                    $hedef->hedef_soru = $hedefSoru;
                    $hedef->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    // If the ID already exists (race condition or manual entry), fetch it
                    if (str_contains($e->getMessage(), 'Duplicate entry')) {
                         $hedef = HaftalikHedef::where('coach_id', $coachId)->where('ders_adi', $dersAdi)->first();
                         if($hedef) {
                            $hedefId = $hedef->id;
                         } else {
                             // This case should be rare, but handle it
                             return response()->json(['status' => 'error', 'message' => 'Varsayılan hedef oluşturulurken bir sorun oluştu.']);
                         }
                    } else {
                        return response()->json(['status' => 'error', 'message' => 'Veritabanı hatası: ' . $e->getMessage()]);
                    }
                }
            }
        }
        
        // If after all checks, hedef is still not found, return error
        if (!$hedef) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hedef bulunamadı veya geçersiz.'
            ]);
        }
        
        // Check if the goal belongs to the student's coach
        if ($hedef->coach_id != $coachId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bu hedef sizin koçunuza ait değil.'
            ]);
        }
        
        // Check if the goal has already been completed today
        $existingCompletion = HedefTamamlama::where('user_id', $userId)
            ->where('hedef_id', $hedefId)
            ->where(function($query) {
                $query->whereDate('tarih', Carbon::today())
                      ->orWhereNull('tarih')
                      ->whereDate('created_at', Carbon::today());
            })
            ->first();
            
        if ($existingCompletion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bu hedefi bugün zaten tamamladınız.'
            ]);
        }
        
        try {
            // Create a new completion record
            $tamamlama = new HedefTamamlama();
            $tamamlama->user_id = $userId;
            $tamamlama->hedef_id = $hedefId;
            $tamamlama->tarih = Carbon::today();
            $tamamlama->tamamlandi = true;
            $tamamlama->tamamlanma_tarihi = Carbon::now();
            $tamamlama->save();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Hedef başarıyla tamamlandı.',
                'tamamlama' => $tamamlama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Veritabanı hatası: ' . $e->getMessage()
            ]);
        }
    }
} 