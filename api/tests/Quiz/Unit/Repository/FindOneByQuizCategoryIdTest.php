<?php

namespace Tests\Quiz\Unit\Repository;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;
use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FindOneByQuizCategoryIdTest extends Base
{
    public function testカテゴリの単体取得を行うこと(): void
    {
        /** @var QuizCategory */
        $quizCategory = QuizCategory::first();
        $foundQuizCategory = $this->quizCategoryRepo->findOneByQuizCategoryId($quizCategory->getQuizCategoryId());

        $this->assertEquals(
            QuizCategoryDTO::from(
                $quizCategory->getQuizCategoryId(),
                $quizCategory->getName(),
                $quizCategory->getFormalName(),
            ),
            $foundQuizCategory,
        );
    }

    public function testカテゴリの単体取得を行えない場合Exceptionが発生すること(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->quizCategoryRepo->findOneByQuizCategoryId(1234);
    }
}
