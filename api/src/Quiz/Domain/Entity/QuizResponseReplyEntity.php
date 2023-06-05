<?php

namespace Eng\Quiz\Domain\Entity;

use Carbon\CarbonImmutable;
use Eng\Chatgpt\Domain\Entity\ChatRole;

class QuizResponseReplyEntity
{
    private ChatRole $role;
    private int $quizResponseReplyId;
    private string $message;
    private CarbonImmutable $sendedAt;

    private function __construct(
        ChatRole $role,
        int $quizResponseReplyId,
        string $message,
        CarbonImmutable $sendedAt,
    ) {
        $this->role = $role;
        $this->quizResponseReplyId = $quizResponseReplyId;
        $this->message = $message;
        $this->sendedAt = $sendedAt;
    }

    public function getRole(): ChatRole
    {
        return $this->role;
    }

    public function getResponseReplyId(): int
    {
        return $this->quizResponseReplyId;
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
            'role'                => $this->getRole(),
            'quizResponseReplyId' => $this->getResponseReplyId(),
            'message'             => $this->getMessage(),
            'sendedAt'            => $this->getSendedAt()->toISOString(),
        ];
    }

    public static function from(
        ChatRole $role,
        int $quizResponseReplyId,
        string $message,
        CarbonImmutable $sendedAt,
    ): self {
        return new self(
            $role,
            $quizResponseReplyId,
            $message,
            $sendedAt,
        );
    }
}
