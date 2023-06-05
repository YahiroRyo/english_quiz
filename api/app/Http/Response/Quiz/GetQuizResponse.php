<?php

namespace App\Http\Response\Quiz;

use App\Http\Response\Response;
use Eng\Quiz\Domain\Entity\QuizEntity;

class GetQuizResponse
{
    public static function success(QuizEntity $quiz)
    {
        return Response::success(
            'クイズの取得に成功しました。',
            $quiz->toJson(),
        );
    }
}
