<?php

namespace Eng\Quiz\Infrastructure\Repository\Interface;

use Eng\Quiz\Domain\DTO\CategoryDTO;

interface QuizCategoryRepository
{
    /** @return CategoryDTO[] */
    public function quizCategoryList(): array;
}
