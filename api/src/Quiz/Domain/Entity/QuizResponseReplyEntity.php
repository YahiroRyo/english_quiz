<?php

namespace Eng\Quiz\Domain\Entity;

use Carbon\CarbonImmutable;

class QuizResponseReplyEntity
{
    private int $replyId;
    private string $message;
    private CarbonImmutable $sendedAt;

    private function __construct(
        int $replyId,
        string $message,
        CarbonImmutable $sendedAt,
    )
    {
        $this->replyId = $replyId;
        $this->message = $message;
        $this->sendedAt = $sendedAt;
    }

    public function getReplyId(): int
    {
        return $this->replyId;
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
            'replyId'  => $this->getReplyId(),
            'message'  => $this->getMessage(),
            'sendedAt' => $this->getSendedAt()->toISOString(),
        ];
    }

    public static function from(
        int $replyId,
        string $message,
        CarbonImmutable $sendedAt,
    ): self
    {
        return new self(
            $replyId,
            $message,
            $sendedAt,
        );
    }
}
