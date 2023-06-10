<?php

namespace Eng\Quiz\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatingQuiz extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
    ];
}
