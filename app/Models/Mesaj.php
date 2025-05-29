<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesaj extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mesajlar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gonderen_id',
        'alici_id',
        'mesaj',
        'tarih',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tarih' => 'datetime',
    ];

    /**
     * Get the sender of the message.
     */
    public function gonderen()
    {
        return $this->belongsTo(User::class, 'gonderen_id');
    }

    /**
     * Get the receiver of the message.
     */
    public function alici()
    {
        return $this->belongsTo(User::class, 'alici_id');
    }
}
