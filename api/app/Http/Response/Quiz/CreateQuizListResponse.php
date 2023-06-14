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
            'クイズの作成を完了しました。',
            array_map(function (QuizEntity $quizEntity) {
                return $quizEntity->toJson();
            },$quizList),
            202
        );
    }
}
