<?php

namespace Eng\Quiz\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class QuizResponse extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $primaryKey = 'quiz_response_id';
    protected $fillable = [
        'quiz_id',
        'answer',
        'is_correct',
    ];

    public function quizResponseReplies(): HasMany
    {
        return $this->hasMany(QuizResponseReply::class, 'quiz_response_id', 'quiz_response_id');
    }

    public function getQuizResponseReplies(): Collection
    {
        return $this->quizResponseReplies;
    }

    public function getQuizResponseId(): int
    {
        return $this->quiz_response_id;
    }

    public function getQuizId(): int
    {
        return $this->quiz_id;
    }

    public function getQuizResponseReplyId(): int
    {
        return $this->quiz_response_reply_id;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getIsCorrect(): bool
    {
        return $this->is_correct;
    }
}
