<?php

namespace Modules\Auth\Entities;

use DateTime;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property DateTime $email_verified_at
 * @property string $email
 * @property mixed $remember_token
 * @property string $password
 * @property string $id
 */
class User extends Model implements MustVerifyEmail, Authenticatable
{
    use HasUuids;
    use Notifiable;

    protected $hidden = [
        'password',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
    ];

    protected $guarded = [
        'id',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
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

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): string
    {
        return $this->id;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->{'remember_token'} = $value;
        $this->save();
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }

}
