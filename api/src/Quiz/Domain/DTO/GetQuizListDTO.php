<?php

namespace Eng\Quiz\Domain\DTO;

class GetQuizListDTO
{
    private int $quizCategoryId;
    private int $currentPageCount;

    private function __construct(int $quizCategoryId, int $currentPageCount)
    {
        $this->quizCategoryId = $quizCategoryId;
        $this->currentPageCount = $currentPageCount;
    }

    public function getQuizCategoryId(): int
    {
        return $this->quizCategoryId;
    }

    public function getCurrentPageCount(): int
    {
        return $this->currentPageCount;
    }

    public function toJson(): array
    {
        return [
            'quizCategoryId'   => $this->getQuizCategoryId(),
            'currentPageCount' => $this->getCurrentPageCount(),
        ];
    }

    public static function from(int $quizCategoryId, int $currentPageCount): self
    {
        return new self(
            $quizCategoryId,
            $currentPageCount,
        );
    }
}
