<?php

namespace App\Http\Response\User;

use App\Http\Response\Response;
use Eng\User\Domain\DTO\UserDTO;

class RegsiterResponse
{
    public static function success(UserDTO $user)
    {
        return Response::success(
            'ユーザーの登録に成功しました。',
            $user->toJson()
        );
    }
}
