<?php

namespace Tests\Quiz\Unit\Service\Query;

use Eng\Quiz\Infrastructure\Repository\DummyQuizCategoryRepository;
use Eng\Quiz\Service\Query\QuizCategoryService;
use Tests\TestCase;

class QuizCategoryServiceTest extends TestCase
{
    public function testカテゴリの単体取得を行うこと(): void
    {
        $quizCategoryId = 1;

        $quizCategoryService = new QuizCategoryService(new DummyQuizCategoryRepository());
        $quizCategory = $quizCategoryService->execute($quizCategoryId);

        $this->assertEquals($quizCategory, (new DummyQuizCategoryRepository())->findOneByQuizCategoryId($quizCategoryId));
    }
}
