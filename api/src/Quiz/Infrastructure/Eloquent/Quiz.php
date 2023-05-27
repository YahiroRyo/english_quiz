<?php

namespace Eng\Quiz\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $primaryKey = 'quiz_id';
    protected $fillable = [
        'user_id',
        'quiz_category_id',
        'prompt',
        'question',
    ];
}
