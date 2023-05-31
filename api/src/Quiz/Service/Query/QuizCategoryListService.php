<?php

namespace Eng\Quiz\Service\Query;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;
use Eng\Quiz\Infrastructure\Repository\Interface\QuizCategoryRepository;

class QuizCategoryListService
{
    private QuizCategoryRepository $quizCategoryRepo;

    public function __construct(QuizCategoryRepository $quizCategoryRepo)
    {
        $this->quizCategoryRepo = $quizCategoryRepo;
    }

    /** @return QuizCategoryDTO[] */
    public function execute(): array
    {
        return $this->quizCategoryRepo->findAll();
    }
}
