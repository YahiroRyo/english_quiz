<?php

namespace App\Http\Response\Quiz;

use App\Http\Response\Response;
use Eng\Quiz\Domain\Entity\QuizEntity;

class CreateQuizListResponse
{
    /**
     * @param QuizEntity[] $quizList
     */
    public static function success(array $quizList)
    {
        return Response::success(
            'クイズの作成に成功しました。',
            array_map(
                function (QuizEntity $quiz) {
                    return $quiz->toJson();
                },
                $quizList,
            )
        );
    }
}
