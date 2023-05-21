<?php

namespace App\Http\Response\User;

use App\Http\Response\Response;
use Eng\User\Domain\DTO\UserDTO;

class LogoutResponse
{
    public static function success(UserDTO $user)
    {
        return Response::success(
            'ログアウトに成功しました。',
            $user->toJson()
        );
    }
}
