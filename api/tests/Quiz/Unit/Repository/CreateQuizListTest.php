<?php

namespace Tests\Quiz\Unit\Repository;

use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\Entity\QuizConstants;
use Eng\Quiz\Infrastructure\Eloquent\Quiz;

class CreateQuizListTest extends Base
{
    public function testクイズ一覧の作成を行うこと(): void
    {
        $quizCategoryList = $this->quizCategoryRepo->findAll();

        $preCount = Quiz::all()->count();

        $this->quizRepo->createQuizList([
            QuizDTO::from(
                QuizConstants::DEFAULT_QUIZ_ID,
                1,
                'question',
                'answer',
                'prompt',
                $quizCategoryList[0],
                QuizResponseDTO::from(
                    QuizConstants::UNRESPONSIVE,
                    false,
                    []
                ),
            )
        ]);

        $this->assertEquals($preCount, Quiz::all()->count() - 1);
    }
}
