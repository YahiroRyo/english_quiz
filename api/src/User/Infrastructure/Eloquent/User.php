<?php

namespace Eng\User\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public const UPDATED_AT = null;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username',
        'password',
    ];

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getActiveUser(): ?ActiveUser
    {
        return $this->activeUser;
    }

    public function getNonActiveUser(): ?NonActiveUser
    {
        return $this->nonActiveUser;
    }

    public function activeUser(): HasOne
    {
        return $this->hasOne(ActiveUser::class, 'user_id', 'user_id');
    }

    public function nonActiveUser(): HasOne
    {
        return $this->hasOne(NonActiveUser::class, 'user_id', 'user_id');
    }
}
