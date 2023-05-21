<?php

namespace Eng\User\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'personality',
        'name',
        'icon',
    ];

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getPersonality(): string
    {
        return $this->personality;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }
}
