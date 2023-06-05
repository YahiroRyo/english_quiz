<?php

namespace Eng\Quiz\Domain\DTO;

class SearchResultQuizListDTO
{
    /** @var QuizDTO[] */
    private array $quizList;
    private int $currentPageCount;
    private int $maxPageCount;

    /**
     * @param QuizDTO[] $quizList
     * @param int $currentPageCount
     * @param int $maxPageCount
     */
    private function __construct(
        array $quizList,
        int $currentPageCount,
        int $maxPageCount,
    ) {
        $this->quizList = $quizList;
        $this->currentPageCount = $currentPageCount;
        $this->maxPageCount = $maxPageCount;
    }

    /**
     * @return QuizDTO[]
     */
    public function getQuizList(): array
    {
        return $this->quizList;
    }

    public function getCurrentPageCount(): int
    {
        return $this->currentPageCount;
    }

    public function getMaxPageCount(): int
    {
        return $this->maxPageCount;
    }

    public static function from(
        array $quizList,
        int $currentPageCount,
        int $maxPageCount,
    ): self {
        return new self(
            $quizList,
            $currentPageCount,
            $maxPageCount,
        );
    }
}
