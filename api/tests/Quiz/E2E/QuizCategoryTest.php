<?php

namespace Tests\Quiz\E2E;

use Eng\Quiz\Infrastructure\Repository\DummyQuizCategoryRepository;
use Eng\Quiz\Service\Query\QuizCategoryService;
use Tests\LoggedInTestCase;

class QuizCategoryTest extends LoggedInTestCase
{
    public function testカテゴリの単体取得を行うこと(): void
    {
        $quizCategoryId = 1;
        $quizCategoryService = new QuizCategoryService(new DummyQuizCategoryRepository());

        $response = $this->get("/api/quiz/categoryList/{$quizCategoryId}", ['Authorization' => 'Bearer ' . $this->token ]);

        $response->assertOk();
        $this->assertEquals(
            $response->json()['data'],
            $quizCategoryService->execute($quizCategoryId)->toJson(),
        );
    }
}
