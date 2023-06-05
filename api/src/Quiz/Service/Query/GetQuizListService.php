<?php

namespace Eng\Quiz\Service\Query;

use Eng\Quiz\Domain\DTO\GetQuizListDTO;
use Eng\Quiz\Domain\DTO\SearchQuizListDTO;
use Eng\Quiz\Domain\Entity\SearchResultQuizListEntity;
use Eng\Quiz\Infrastructure\Repository\Interface\QuizRepository;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;

class GetQuizListService
{
    private QuizRepository $quizRepo;
    private UserRepository $userRepo;

    public function __construct(QuizRepository $quizRepo, UserRepository $userRepo)
    {
        $this->quizRepo = $quizRepo;
        $this->userRepo = $userRepo;
    }

    public function execute(GetQuizListDTO $getQuizListDTO): SearchResultQuizListEntity
    {
        $me = $this->userRepo->findMe();

        $searchQuizListDTO = SearchQuizListDTO::from(
            $me->getUserId(),
            $getQuizListDTO->getQuizCategoryId(),
            $getQuizListDTO->getCurrentPageCount()
        );

        return SearchResultQuizListEntity::fromDTO($this->quizRepo->findAllBySearchQuizListDTO($searchQuizListDTO));
    }
}
