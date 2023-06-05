<?php

namespace Eng\Quiz\Infrastructure\Repository\Interface;

use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\SearchQuizDTO;
use Eng\Quiz\Domain\DTO\SearchQuizListDTO;
use Eng\Quiz\Domain\DTO\SearchResultQuizListDTO;

interface QuizRepository
{
    /**
     * @param QuizDTO[] $quizDTOList
     * @return QuizDTO[]
     */
    public function createQuizList(array $quizDTOList): array;

    public function save(QuizDTO $quizDTO): QuizDTO;

    public function findAllBySearchQuizListDTO(SearchQuizListDTO $searchQuizListDTO): SearchResultQuizListDTO;

    public function findOneBySearchQuizDTO(SearchQuizDTO $searchQuizDTO): QuizDTO;
}
