<?php

namespace Tests\Quiz\Unit\Service\Query;

use Eng\Quiz\Infrastructure\Repository\DummyQuizCategoryRepository;
use Eng\Quiz\Service\Query\QuizCategoryListService;
use Tests\TestCase;

class QuizCategoryListServiceTest extends TestCase
{
    public function testカテゴリ一覧の取得を行うこと(): void
    {
        $quizCategoryListService = new QuizCategoryListService(new DummyQuizCategoryRepository());
        $quizCategoryList = $quizCategoryListService->execute();

        $this->assertEquals($quizCategoryList, (new DummyQuizCategoryRepository())->findAll());
    }
}
