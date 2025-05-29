<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaftalikHedef extends Model
{
    use HasFactory;

    protected $table = 'haftalik_hedefler';

    protected $fillable = [
        'coach_id',
        'gun',
        'ders_adi',
        'hedef_soru'
    ];

    /**
     * Get the coach that owns the weekly goal.
     */
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    /**
     * Get the completion records for this goal.
     */
    public function tamamlamalar()
    {
        return $this->hasMany(HedefTamamlama::class, 'hedef_id');
    }
} 