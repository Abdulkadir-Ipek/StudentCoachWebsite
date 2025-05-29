<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HedefTamamlama extends Model
{
    use HasFactory;

    protected $table = 'hedef_tamamlamalar';

    protected $fillable = [
        'user_id',
        'hedef_id',
        'tarih',
        'tamamlandi',
        'tamamlanma_tarihi'
    ];

    protected $casts = [
        'tamamlandi' => 'boolean',
        'tamamlanma_tarihi' => 'datetime',
        'tarih' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function haftalikHedef()
    {
        return $this->belongsTo(HaftalikHedef::class, 'hedef_id');
    }
}
