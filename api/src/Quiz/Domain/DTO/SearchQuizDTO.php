<?php

namespace Eng\Quiz\Domain\DTO;

class SearchQuizDTO
{
    private int $userId;
    private int $quizId;

    private function __construct(int $userId, int $quizId)
    {
        $this->userId = $userId;
        $this->quizId = $quizId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getQuizId(): int
    {
        return $this->quizId;
    }

    public static function from(int $userId, int $quizId): self
    {
        return new self(
            $userId,
            $quizId,
        );
    }
}
