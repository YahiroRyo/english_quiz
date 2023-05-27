<?php

namespace Eng\Quiz\Infrastructure\Repository;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;
use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;

class QuizCategoryRepository implements \Eng\Quiz\Infrastructure\Repository\Interface\QuizCategoryRepository
{
    /** @return QuizCategoryDTO[] */
    public function quizCategoryList(): array
    {
        return QuizCategory::all()
            ->map(function (QuizCategory $category) {
                return QuizCategoryDTO::from(
                    $category->getQuizCategoryId(),
                    $category->getName(),
                    $category->getFormalName(),
                );
            })
            ->toArray();
    }
}
