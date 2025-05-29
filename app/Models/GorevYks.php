<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GorevYks extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gorevler_yks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'coach_id',
        'ders_adi',
        'toplam_soru_sayisi',
        'hedef_tarih',
        'olusturma_tarihi'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'hedef_tarih' => 'date',
        'olusturma_tarihi' => 'datetime',
    ];

    /**
     * Get the student associated with the task.
     */
    public function ogrenci()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the coach associated with the task.
     */
    public function koc()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    /**
     * Get the results associated with the task.
     */
    public function sonuclar()
    {
        return $this->hasMany(SoruSonucu::class, 'gorev_id');
    }
}
