<?php

namespace App\Http\Response\User;

use App\Http\Response\Response;
use Eng\User\Domain\DTO\UserDTO;

class LoginResponse
{
    public static function success(UserDTO $user)
    {
        return Response::success(
            'ログインに成功しました。',
            $user->toJson()
        );
    }
}
