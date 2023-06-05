<?php

namespace Eng\Quiz\Domain\Entity;

use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\SearchResultQuizListDTO;

class SearchResultQuizListEntity
{
    /** @var QuizEntity[] */
    private array $quizList;
    private int $currentPageCount;
    private int $maxPageCount;

    /**
     * @param QuizEntity[] $quizList
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

    public function toJson(): array
    {
        return [
            'quizList' => collect($this->getQuizList())
                ->map(function (QuizEntity $quiz) {
                    return $quiz->toJson();
                })
                ->toArray(),
            'currentPageCount' => $this->getCurrentPageCount(),
            'maxPageCount'     => $this->getMaxPageCount(),
        ];
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

    public static function fromDTO(
        SearchResultQuizListDTO $searchQuizListDTO,
    ): self {
        return new self(
            collect($searchQuizListDTO->getQuizList())
                ->map(function (QuizDTO $quiz) {
                    return QuizEntity::fromDTO($quiz);
                })
                ->toArray(),
            $searchQuizListDTO->getCurrentPageCount(),
            $searchQuizListDTO->getMaxPageCount(),
        );
    }
}
