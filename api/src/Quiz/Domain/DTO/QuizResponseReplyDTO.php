<?php

namespace Eng\Quiz\Domain\DTO;

use Carbon\CarbonImmutable;

class QuizResponseReplyDTO
{
    private int $quizResponseReplyId;
    private int $quizResponseId;
    private string $role;
    private string $message;
    private string $functionName;
    private CarbonImmutable $sendedAt;

    private function __construct(
        int $quizResponseReplyId,
        int $quizResponseId,
        string $role,
        string $message,
        string $functionName,
        CarbonImmutable $sendedAt,
    ) {
        $this->quizResponseReplyId = $quizResponseReplyId;
        $this->quizResponseId = $quizResponseId;
        $this->role = $role;
        $this->message = $message;
        $this->functionName = $functionName;
        $this->sendedAt = $sendedAt;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getQuizResponseReplyId(): int
    {
        return $this->quizResponseReplyId;
    }

    public function getQuizResponseId(): int
    {
        return $this->quizResponseId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getFunctionName(): string
    {
        return $this->functionName;
    }

    public function getSendedAt(): CarbonImmutable
    {
        return $this->sendedAt;
    }

    public static function from(
        int $quizResponseReplyId,
        int $quizResponseId,
        string $role,
        string $message,
        string $functionName,
        CarbonImmutable $sendedAt,
    ): self {
        return new self(
            $quizResponseReplyId,
            $quizResponseId,
            $role,
            $message,
            $functionName,
            $sendedAt,
        );
    }
}
