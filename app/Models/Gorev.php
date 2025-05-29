<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gorev extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gorevler';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'coach_id',
        'gorev_adi',
        'aciklama',
        'tamamlanma_orani',
        'tarih'
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the coach that assigned the task.
     */
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
