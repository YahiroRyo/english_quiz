<?php

namespace Eng\Quiz\Infrastructure\Repository;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;
use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;

class QuizCategoryRepository implements \Eng\Quiz\Infrastructure\Repository\Interface\QuizCategoryRepository
{
    /** @return QuizCategoryDTO[] */
    public function findAll(): array
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

    public function findOneByQuizCategoryId(int $quizCategoryId): QuizCategoryDTO
    {
        /** @var QuizCategory */
        $quizCategory = QuizCategory::findOrFail($quizCategoryId);

        return QuizCategoryDTO::from(
            $quizCategory->getQuizCategoryId(),
            $quizCategory->getName(),
            $quizCategory->getFormalName(),
        );
    }
}
