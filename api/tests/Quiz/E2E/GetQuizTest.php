<?php

namespace Tests\Quiz\E2E;

use Eng\Quiz\Infrastructure\Eloquent\Quiz;
use Eng\Quiz\Infrastructure\Repository\DummyQuizRepository;
use Eng\Quiz\Service\Query\GetQuizService;
use Eng\User\Infrastructure\Repository\UserRepository;
use Tests\LoggedInTestCase;

class GetQuizTest extends LoggedInTestCase
{
    public function testクイズの単体取得を行うこと(): void
    {
        /** @var Quiz */
        $quiz = Quiz::first();

        $getQuizService = new GetQuizService(
            new DummyQuizRepository(),
            new UserRepository(),
        );
        $response = $this->get(
            '/api/quiz/' . $quiz->getQuizId(),
            ['Authorization' => 'Bearer ' . $this->token ]
        );
        $response->assertOk();
        $responseData = $response->json('data');

        $this->assertEquals(
            $responseData,
            $getQuizService->execute($quiz->getQuizId())->toJson(),
        );
    }
}
