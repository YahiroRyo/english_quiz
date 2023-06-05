<?php

namespace App\Http\Response\Quiz;

use App\Http\Response\Response;
use Eng\Quiz\Domain\Entity\SearchResultQuizListEntity;

class GetQuizListResponse
{
    public static function success(SearchResultQuizListEntity $searchResultQuizListEntity)
    {
        return Response::success(
            'クイズの一覧取得に成功しました。',
            $searchResultQuizListEntity->toJson(),
        );
    }
}
