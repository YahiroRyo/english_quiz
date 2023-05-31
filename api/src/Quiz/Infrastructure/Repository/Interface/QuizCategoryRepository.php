<?php

namespace Eng\Quiz\Infrastructure\Repository\Interface;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;

interface QuizCategoryRepository
{
    /** @return QuizCategoryDTO[] */
    public function findAll(): array;

    public function findOneByQuizCategoryId(int $quizCategoryId): QuizCategoryDTO;
}
