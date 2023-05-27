<?php

namespace Tests;

use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Eng\User\Infrastructure\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class LoggedInTestCase extends TestCase
{
    protected User $user;
    protected string $password;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->password = 'password';
        $this->user = User::create([
            'username' => 'testUsername',
            'password' => Hash::make($this->password),
        ]);
        ActiveUser::create([
            'user_id' => $this->user->getUserId(),
            'personality' => 'personality',
            'name' => 'name',
            'icon' => 'icon',
        ]);

        $userDTO = (new UserRepository())->createTokenByUserId($this->user->getUserId());
        $this->token = $userDTO->getToken();
    }
}
