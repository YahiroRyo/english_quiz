<?php

namespace App\Http\Response\Quiz;

use App\Http\Response\Response;
use Eng\Quiz\Domain\DTO\QuizCategoryDTO;

class QuizCategoryListResponse
{
    /**
     * @param QuizCategoryDTO[] $quizCategoryList
     */
    public static function success(array $quizCategoryList)
    {
        return Response::success(
            'ログインに成功しました。',
            array_map(function (QuizCategoryDTO $quizCategoryDTO) {
                return $quizCategoryDTO->toJson();
            }, $quizCategoryList)
        );
    }
}
