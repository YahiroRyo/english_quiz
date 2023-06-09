<?php

namespace App\Http\Response\Quiz;

use App\Http\Response\Response;

class CreateQuizListResponse
{
    public static function success()
    {
        return Response::success(
            'クイズの作成に成功しました。',
            []
        );
    }
}
