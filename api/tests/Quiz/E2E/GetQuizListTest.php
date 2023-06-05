<?php

namespace Tests\Quiz\E2E;

use Eng\Quiz\Domain\DTO\GetQuizListDTO;
use Eng\Quiz\Infrastructure\Repository\DummyQuizRepository;
use Eng\Quiz\Service\Query\GetQuizListService;
use Eng\User\Infrastructure\Repository\UserRepository;
use Tests\LoggedInTestCase;

class GetQuizListTest extends LoggedInTestCase
{
    public function testクイズの一覧取得を行うこと(): void
    {
        $getQuizListDTO = GetQuizListDTO::from(1, 1);
        $query = http_build_query($getQuizListDTO->toJson());

        $getQuizListService = new GetQuizListService(
            new DummyQuizRepository(),
            new UserRepository(),
        );
        $response = $this->get(
            '/api/quiz?' . $query,
            ['Authorization' => 'Bearer ' . $this->token ]
        );
        $response->assertOk();
        $responseData = $response->json('data');

        $this->assertEquals(
            $responseData,
            $getQuizListService->execute($getQuizListDTO)->toJson(),
        );
    }
}
