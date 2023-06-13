<?php

namespace Eng\Quiz\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'speech_answer_url'
    ];

    public function quizCategory(): HasOne
    {
        return $this->hasOne(QuizCategory::class, 'quiz_category_id', 'quiz_category_id');
    }

    public function quizResponse(): HasOne
    {
        return $this->hasOne(QuizResponse::class, 'quiz_id', 'quiz_id');
    }

    public function getQuizCategory(): QuizCategory
    {
        return $this->quizCategory;
    }

    public function getResponse(): ?QuizResponse
    {
        return $this->quizResponse;
    }

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

    public function getSpeechAnswerUrl(): string
    {
        return $this->speech_answer_url;
    }
}
