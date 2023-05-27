<?php

namespace Eng\Quiz\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResponse extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $primaryKey = 'quiz_id';
    protected $fillable = [
        'quiz_id',
        'answer',
        'is_correct',
    ];
}
