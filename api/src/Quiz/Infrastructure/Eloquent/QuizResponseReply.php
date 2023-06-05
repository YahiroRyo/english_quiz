<?php

namespace Eng\Quiz\Infrastructure\Eloquent;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResponseReply extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $primaryKey = 'quiz_response_reply_id';
    protected $fillable = [
        'quiz_response_id',
        'role',
        'message',
    ];

    public function getQuizResponseReplyId(): int
    {
        return $this->quiz_response_reply_id;
    }

    public function getQuizResponseId(): int
    {
        return $this->quiz_response_id;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getResponseId(): string
    {
        return $this->response_id;
    }

    public function getSendedAt(): CarbonImmutable
    {
        return new CarbonImmutable($this->created_at);
    }
}
