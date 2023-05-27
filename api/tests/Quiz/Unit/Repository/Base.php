<?php

namespace Tests\Quiz\Unit\Repository;

use Eng\Quiz\Infrastructure\Repository\QuizCategoryRepository;
use Tests\TestCase;

class Base extends TestCase
{
    protected QuizCategoryRepository $quizCategoryRepo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->quizCategoryRepo = new QuizCategoryRepository();
    }
}
