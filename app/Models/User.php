<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'coach_id',
        'profile_photo',
        'alan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the tasks of the user.
     */
    public function gorevler()
    {
        return $this->hasMany(Gorev::class);
    }

    /**
     * Get the YKS tasks of the student.
     */
    public function gorevlerYks()
    {
        return $this->hasMany(GorevYks::class, 'user_id');
    }

    /**
     * Get the YKS tasks assigned by the coach.
     */
    public function verdigiGorevlerYks()
    {
        return $this->hasMany(GorevYks::class, 'coach_id');
    }

    /**
     * Get the question results of the student.
     */
    public function soruSonuclari()
    {
        return $this->hasMany(SoruSonucu::class, 'user_id');
    }

    /**
     * Get the received messages of the user.
     */
    public function alinanMesajlar()
    {
        return $this->hasMany(Mesaj::class, 'alici_id');
    }

    /**
     * Get the sent messages of the user.
     */
    public function gonderilenMesajlar()
    {
        return $this->hasMany(Mesaj::class, 'gonderen_id');
    }

    /**
     * Get the targets of the user.
     */
    public function hedefler()
    {
        return $this->hasMany(Hedef::class);
    }

    /**
     * Get the weekly goals created by the coach.
     */
    public function haftalikHedefler()
    {
        return $this->hasMany(HaftalikHedef::class, 'coach_id');
    }

    /**
     * Get the goal completions by the student.
     */
    public function hedefTamamlamalar()
    {
        return $this->hasMany(HedefTamamlama::class, 'user_id');
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}
