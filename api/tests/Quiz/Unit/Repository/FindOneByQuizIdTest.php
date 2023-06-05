<?php

namespace Tests\Quiz\Unit\Repository;

use Eng\Quiz\Domain\DTO\SearchQuizDTO;
use Eng\Quiz\Infrastructure\Eloquent\Quiz;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FindOneByQuizIdTest extends Base
{
    public function testクイズの単体取得を行うこと(): void
    {
        /** @var Quiz */
        $quiz = Quiz::first();

        $foundQuiz = $this->quizRepo->findOneBySearchQuizDTO(SearchQuizDTO::from(
            $quiz->getUserId(),
            $quiz->getQuizId(),
        ));

        $this->assertEquals(
            $quiz->getQuizId(),
            $foundQuiz->getQuizId(),
        );
    }

    public function testクイズの単体取得を行えない場合Exceptionが発生すること(): void
    {
        /** @var Quiz */
        $quiz = Quiz::first();

        $this->expectException(ModelNotFoundException::class);

        $this->quizRepo->findOneBySearchQuizDTO(SearchQuizDTO::from(
            $quiz->getUserId(),
            1234,
        ));
    }
}
