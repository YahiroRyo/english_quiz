<?php

namespace Eng\Quiz\Domain\DTO;

use Carbon\CarbonImmutable;

class AddMessageToQuizDTO
{
    private int $quizId;
    private string $message;
    private CarbonImmutable $sendedAt;

    private function __construct(int $quizId, string $message, CarbonImmutable $sendedAt)
    {
        $this->quizId   = $quizId;
        $this->message  = $message;
        $this->sendedAt = $sendedAt;
    }

    public function getQuizId(): int
    {
        return $this->quizId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSendedAt(): CarbonImmutable
    {
        return $this->sendedAt;
    }

    public function toJson(): array
    {
        return [
            'quizId'   => $this->getQuizId(),
            'message'  => $this->getMessage(),
            'sendedAt' => $this->getSendedAt()->toISOString(),
        ];
    }

    public static function from(int $quizId, string $message, CarbonImmutable $sendedAt): self
    {
        return new self(
            $quizId,
            $message,
            $sendedAt,
        );
    }
}
