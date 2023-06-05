<?php

namespace Tests\Quiz\Unit\Service\Query;

use Eng\Quiz\Domain\DTO\GetQuizListDTO;
use Eng\Quiz\Domain\DTO\SearchQuizListDTO;
use Eng\Quiz\Domain\Entity\SearchResultQuizListEntity;
use Eng\Quiz\Infrastructure\Repository\DummyQuizRepository;
use Eng\Quiz\Service\Query\GetQuizListService;
use Eng\User\Infrastructure\Repository\UserRepository;
use Tests\LoggedInTestCase;

class GetQuizListServiceTest extends LoggedInTestCase
{
    public function testクイズ一覧取得を行うこと(): void
    {
        $getQuizListService = new GetQuizListService(
            new DummyQuizRepository(),
            new UserRepository(),
        );
        $getQuizListDTO = GetQuizListDTO::from(1, 1);

        $quizList = $getQuizListService->execute($getQuizListDTO);

        $this->assertEquals(
            $quizList,
            SearchResultQuizListEntity::fromDTO(
                (new DummyQuizRepository())->findAllBySearchQuizListDTO(SearchQuizListDTO::from(
                    1,
                    $getQuizListDTO->getQuizCategoryId(),
                    $getQuizListDTO->getCurrentPageCount(),
                ))
            )
        );
    }
}
