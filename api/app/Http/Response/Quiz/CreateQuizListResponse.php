<?php

namespace App\Http\Response\Quiz;

use App\Http\Response\Response;

class CreateQuizListResponse
{
    public static function success()
    {
        return Response::success(
            'クイズを作成中です。しばらくお待ちください。',
            [],
            202
        );
    }
}
