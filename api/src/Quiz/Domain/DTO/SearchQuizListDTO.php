<?php

namespace Eng\Quiz\Domain\DTO;

class SearchQuizListDTO
{
    private int $userId;
    private int $quizCategoryId;
    private int $currentPageCount;

    private function __construct(int $userId, int $quizCategoryId, int $currentPageCount)
    {
        $this->userId = $userId;
        $this->quizCategoryId = $quizCategoryId;
        $this->currentPageCount = $currentPageCount;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getQuizCategoryId(): int
    {
        return $this->quizCategoryId;
    }

    public function getCurrentPageCount(): int
    {
        return $this->currentPageCount;
    }

    public static function from(int $userId, int $quizCategoryId, int $currentPageCount): self
    {
        return new self(
            $userId,
            $quizCategoryId,
            $currentPageCount,
        );
    }
}
