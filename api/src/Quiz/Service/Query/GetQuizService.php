<?php

namespace Eng\Quiz\Service\Query;

use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\SearchQuizDTO;
use Eng\Quiz\Domain\Entity\QuizEntity;
use Eng\Quiz\Infrastructure\Repository\Interface\QuizRepository;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;

class GetQuizService
{
    private QuizRepository $quizRepo;
    private UserRepository $userRepo;

    public function __construct(QuizRepository $quizRepo, UserRepository $userRepo)
    {
        $this->quizRepo = $quizRepo;
        $this->userRepo = $userRepo;
    }

    public function execute(int $quizId): QuizEntity
    {
        $me = $this->userRepo->findMe();

        $searchQuizDTO = SearchQuizDTO::from(
            $me->getUserId(),
            $quizId,
        );

        $quizDTO = $this->quizRepo->findOneBySearchQuizDTO($searchQuizDTO);
        return QuizEntity::fromDTO($quizDTO);
    }
}
