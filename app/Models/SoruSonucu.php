<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoruSonucu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'soru_sonuclari';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'gorev_id',
        'ders_adi',
        'cozuldu_soru',
        'dogru',
        'yanlis',
        'bos',
        'tarih',
        'onay_durumu',
        'onay_tarihi',
        'not'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tarih' => 'date',
        'onay_tarihi' => 'datetime',
    ];

    /**
     * Get the user that owns the result.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the task that owns the result.
     */
    public function gorev()
    {
        return $this->belongsTo(GorevYks::class, 'gorev_id');
    }
}
