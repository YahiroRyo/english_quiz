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
        'answer',
    ];

    public function getQuizId(): int
    {
        return $this->quiz_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getQuizCategoryId(): string
    {
        return $this->quiz_category_id;
    }

    public function getPrompt(): string
    {
        return $this->prompt;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }
}
