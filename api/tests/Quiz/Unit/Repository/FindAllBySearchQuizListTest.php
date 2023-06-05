<?php

namespace Tests\Quiz\Unit\Repository;

use Eng\Quiz\Domain\DTO\SearchQuizListDTO;
use Eng\Quiz\Infrastructure\Eloquent\Quiz;
use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;
use Eng\User\Infrastructure\Eloquent\User;

class FindAllBySearchQuizListTest extends Base
{
    public function testカテゴリ一覧の取得を行うこと(): void
    {
        $userId = User::first()->getUserId();
        $quizCategoryId = QuizCategory::first()->getQuizCategoryId();

        $quizListCount = Quiz::where('user_id', $userId)
            ->where('quiz_category_id', $quizCategoryId)
            ->get()
            ->count();

        $searchResultQuizList = $this->quizRepo->findAllBySearchQuizListDTO(
            SearchQuizListDTO::from(
                $userId,
                $quizCategoryId,
                1,
            ),
        );

        $this->assertEquals($quizListCount, count($searchResultQuizList->getQuizList()));
    }
}
