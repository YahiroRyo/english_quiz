<?php

namespace Tests\Quiz\E2E;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;
use Eng\Quiz\Infrastructure\Repository\DummyQuizCategoryRepository;
use Eng\Quiz\Service\Query\QuizCategoryListService;
use Tests\LoggedInTestCase;

class CategoryListTest extends LoggedInTestCase
{
    public function testカテゴリ一覧の取得を行うこと(): void
    {
        $quizCategoryListService = new QuizCategoryListService(new DummyQuizCategoryRepository());

        $response = $this->get('/api/quiz/categoryList', ['Authorization' => 'Bearer ' . $this->token ]);

        $response->assertOk();
        $this->assertEquals(
            $response->json()['data'],
            array_map(function (QuizCategoryDTO $quizCategoryDTO) {
                return $quizCategoryDTO->toJson();
            }, $quizCategoryListService->execute()),
        );
    }
}
