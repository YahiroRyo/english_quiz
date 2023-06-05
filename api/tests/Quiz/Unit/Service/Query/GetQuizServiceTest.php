<?php

namespace Tests\Quiz\Unit\Service\Query;

use Eng\Quiz\Domain\DTO\SearchQuizDTO;
use Eng\Quiz\Domain\Entity\QuizEntity;
use Eng\Quiz\Infrastructure\Repository\DummyQuizRepository;
use Eng\Quiz\Service\Query\GetQuizService;
use Eng\User\Infrastructure\Repository\UserRepository;
use Tests\LoggedInTestCase;

class GetQuizServiceTest extends LoggedInTestCase
{
    public function testクイズ単体取得を行うこと(): void
    {
        $getQuizService = new GetQuizService(
            new DummyQuizRepository(),
            new UserRepository(),
        );

        $quiz = $getQuizService->execute(1);

        $this->assertEquals(
            $quiz->toJson(),
            QuizEntity::fromDTO(
                (new DummyQuizRepository())->findOneBySearchQuizDTO(
                    SearchQuizDTO::from(auth()->id(), 1)
                )
            )->toJson(),
        );
    }
}
