<?php

namespace App\Http\Response\Quiz;

use App\Http\Response\Response;
use Eng\Quiz\Domain\DTO\QuizCategoryDTO;

class QuizCategoryResponse
{
    public static function success(QuizCategoryDTO $quizCategory)
    {
        return Response::success(
            'カテゴリの取得に成功しました。',
            $quizCategory->toJson(),
        );
    }
}
