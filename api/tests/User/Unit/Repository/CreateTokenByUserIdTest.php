<?php

namespace Tests\User\Unit\Repository;

use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateTokenByUserIdTest extends Base
{
    private User $user;
    private string $password;

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
    }

    public function testユーザーのトークン生成を行う(): void
    {
        $user = $this->userRepo->createTokenByUserId($this->user->getUserId());

        /** @var User */
        $changedUser = User::find($this->user->getUserId());

        $tokenId = Str::before($user->getToken(), '|');
        $this->assertEquals($tokenId, $changedUser->tokens()->first()->id);
    }

    public function testユーザーが存在しなかった場合Exceptionが発生すること(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->userRepo->createTokenByUserId(1234);
    }
}
