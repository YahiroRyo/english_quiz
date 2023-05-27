<?php

namespace Eng\Quiz\Infrastructure\Repository;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;

class DummyQuizCategoryRepository implements \Eng\Quiz\Infrastructure\Repository\Interface\QuizCategoryRepository
{
    /** @return QuizCategoryDTO[] */
    public function quizCategoryList(): array
    {
        return [
            QuizCategoryDTO::from(1, '副詞', '副詞'),
            QuizCategoryDTO::from(2, '疑問詞', '疑問詞'),
            QuizCategoryDTO::from(3, '前置詞', '前置詞'),
        ];
    }
}
