<?php

namespace Eng\Quiz\Service\Query;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;
use Eng\Quiz\Infrastructure\Repository\Interface\QuizCategoryRepository;

class QuizCategoryService
{
    private QuizCategoryRepository $quizCategoryRepo;

    public function __construct(QuizCategoryRepository $quizCategoryRepo)
    {
        $this->quizCategoryRepo = $quizCategoryRepo;
    }

    public function execute(int $quizCategoryId): QuizCategoryDTO
    {
        return $this->quizCategoryRepo->findOneByQuizCategoryId($quizCategoryId);
    }
}
