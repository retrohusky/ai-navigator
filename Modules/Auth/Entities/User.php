<?php

namespace Modules\Auth\Entities;

use DateTime;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property DateTime $email_verified_at
 * @property string $email
 */
class User extends Model implements MustVerifyEmail
{
    use HasUuids;
    use Notifiable;

    protected $hidden = [
        'password',
        'updated_at'
    ];

    protected $guarded = [
        'id',
        'updated_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasVerifiedEmail(): bool
    {
        return !is_null( $this->email_verified_at );
    }

    public function markEmailAsVerified(): bool
    {
        $this->email_verified_at = now();
        return $this->save();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify( new VerifyEmail );
    }

    public function getEmailForVerification(): string
    {
        return $this->email;
    }
}
