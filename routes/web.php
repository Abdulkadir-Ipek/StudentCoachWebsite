<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KocController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', [HomeController::class, 'index']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware(['auth', 'verified']);

// Email Verification Routes
Route::get('/email/verify', [AuthController::class, 'verificationNotice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
    ->name('verification.send');

// Forgot Password Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Student Routes - Required to be verified
Route::get('/ogrenci-panel', [AuthController::class, 'ogrenciPanel'])->middleware(['auth', 'verified']);
Route::get('/profilim', [AuthController::class, 'profilim'])->middleware(['auth', 'verified']);
Route::post('/profilim-guncelle', [AuthController::class, 'profilimGuncelle'])->middleware(['auth', 'verified']);
Route::get('/istatistikler', [AuthController::class, 'istatistikler'])->middleware(['auth', 'verified']);
Route::post('/koc-sec', [AuthController::class, 'kocSec'])->middleware(['auth', 'verified'])->name('koc-sec');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Student YKS Result Routes
Route::post('/sonuc-kaydet', [AuthController::class, 'sonucKaydet'])->middleware(['auth', 'verified'])->name('sonuc-kaydet');

// Student Messaging Routes
Route::get('/ogrenci/mesajlar', [AuthController::class, 'mesajlar'])->middleware(['auth', 'verified']);
Route::get('/ogrenci/mesajlar/veri', [AuthController::class, 'mesajlarVeri'])->middleware(['auth', 'verified']);
Route::post('/ogrenci/mesaj-gonder', [AuthController::class, 'mesajGonder'])->middleware(['auth', 'verified']);

// Student Goal Completion Route
Route::post('/hedef-tamamla', [HomeController::class, 'hedefTamamla'])->middleware('auth')->name('hedef-tamamla');

// Koç Panel Routes
Route::get('/koc/panel', [KocController::class, 'panel'])->middleware('auth');
Route::get('/koc/ogrenciler', [KocController::class, 'ogrenciler'])->middleware('auth');
Route::get('/koc/gorevler', [KocController::class, 'gorevler'])->middleware('auth');
Route::get('/koc/ogrenci-gorevler/{id}', [KocController::class, 'ogrenciGorevler'])->middleware('auth');
Route::get('/koc/mesajlar', [KocController::class, 'mesajlar'])->middleware('auth');
Route::get('/koc/mesajlar/veri', [KocController::class, 'mesajlarVeri'])->middleware('auth');
Route::get('/koc/istatistik', [KocController::class, 'istatistik'])->middleware('auth');
Route::get('/koc/profil', [KocController::class, 'profil'])->middleware('auth');
Route::post('/koc/profil-guncelle', [KocController::class, 'profilGuncelle'])->middleware('auth');
Route::post('/koc/gorev-ekle', [KocController::class, 'gorevEkle'])->middleware('auth');
Route::post('/koc/gorev-sil/{id}', [KocController::class, 'gorevSil'])->middleware('auth');
Route::post('/koc/gorev-yks-sil/{id}', [KocController::class, 'gorevYksSil'])->middleware('auth');
Route::post('/koc/gorev-guncelle/{id}', [KocController::class, 'gorevGuncelle'])->middleware('auth');
Route::post('/koc/mesaj-gonder', [KocController::class, 'mesajGonder'])->middleware('auth');

// Haftalık Hedef Routes
Route::post('/koc/haftalik-hedef-ekle', [KocController::class, 'haftalikHedefEkle'])->middleware('auth');
Route::get('/koc/haftalik-hedefler/{gun}', [KocController::class, 'haftalikHedefler'])->middleware('auth');
Route::post('/koc/haftalik-hedef-sil/{id}', [KocController::class, 'haftalikHedefSil'])->middleware('auth');
Route::post('/alan-sec', [AuthController::class, 'alanSec'])->middleware('auth')->name('alan-sec');
Route::get('/ogrenci/siralama', [AuthController::class, 'siralama'])->middleware('auth')->name('siralama');

// Coach Routes
Route::get('/koc/panel', [KocController::class, 'panel'])->middleware('auth');
Route::get('/koc/ogrenciler', [KocController::class, 'ogrenciler'])->middleware('auth');
Route::get('/koc/gorevler', [KocController::class, 'gorevler'])->middleware('auth');
Route::post('/koc/gorev-ekle', [KocController::class, 'gorevEkle'])->middleware('auth');
Route::get('/koc/mesajlar', [KocController::class, 'mesajlar'])->middleware('auth');
Route::get('/koc/mesajlar/veri', [KocController::class, 'mesajlarVeri'])->middleware('auth');
Route::post('/koc/mesaj-gonder', [KocController::class, 'mesajGonder'])->middleware('auth');
Route::get('/koc/istatistik', [KocController::class, 'istatistik'])->middleware('auth');
Route::get('/koc/profil', [KocController::class, 'profil'])->middleware('auth');
Route::post('/koc/profil-guncelle', [KocController::class, 'profilGuncelle'])->middleware('auth');
Route::delete('/koc/gorev-sil/{id}', [KocController::class, 'gorevSil'])->middleware('auth');
Route::delete('/koc/gorev-yks-sil/{id}', [KocController::class, 'gorevYksSil'])->middleware('auth');
Route::get('/koc/ogrenci/{id}/gorevler', [KocController::class, 'ogrenciGorevler'])->middleware('auth');

// Coach - Weekly Goals Routes
Route::post('/koc/haftalik-hedef-ekle', [KocController::class, 'haftalikHedefEkle'])->middleware('auth');
Route::get('/koc/haftalik-hedefler/{gun}', [KocController::class, 'haftalikHedefler'])->middleware('auth');
Route::delete('/koc/haftalik-hedef-sil/{id}', [KocController::class, 'haftalikHedefSil'])->middleware('auth');

// Coach - Task Result Approval Routes
Route::get('/koc/bekleyen-sonuclar', [KocController::class, 'onayBekleyenSonuclar'])->middleware('auth');
Route::post('/koc/sonuc-onayla/{id}', [KocController::class, 'sonucOnayla'])->middleware('auth');

