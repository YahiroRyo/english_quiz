<?php

namespace Eng\Quiz\Infrastructure\Repository\Interface;

use Eng\Quiz\Domain\DTO\QuizDTO;

interface QuizRepository
{
    /**
     * @param QuizDTO[] $quizDTOList
     * @return QuizDTO[]
     */
    public function createQuizList(array $quizDTOList): array;
}
