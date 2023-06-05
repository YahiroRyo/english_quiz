<?php

namespace App\Http\Response\Quiz;

use App\Http\Response\Response;
use Eng\Quiz\Domain\Entity\QuizEntity;

class AddMessageResponse
{
    public static function success(QuizEntity $quiz)
    {
        return Response::success(
            'メッセージを送信しました。',
            collect($quiz->getQuizResponseEntity()->getReplyList())
                ->last()
                ->toJson(),
        );
    }
}
