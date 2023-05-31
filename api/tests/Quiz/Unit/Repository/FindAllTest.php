<?php

namespace Tests\Quiz\Unit\Repository;

use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;

class FindAllTest extends Base
{
    public function testカテゴリ一覧の取得を行うこと(): void
    {
        $quizCategoryList = $this->quizCategoryRepo->findAll();

        $this->assertCount(QuizCategory::all()->count(), $quizCategoryList);
    }
}
