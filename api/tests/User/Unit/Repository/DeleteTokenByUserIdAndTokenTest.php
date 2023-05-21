<?php

namespace Tests\User\Unit\Repository;

use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DeleteTokenByUserIdAndTokenTest extends Base
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

    public function testトークンの削除を行うこと(): void
    {
        $generatedTokenUser = $this->userRepo->createTokenByUserId($this->user->getUserId());
        $this->userRepo->deleteTokenByUserIdAndToken(
            $this->user->getUserId(),
            $generatedTokenUser->getToken()
        );

        $tokenMetaData = $this->user->tokens()->find(Str::before($generatedTokenUser->getToken(), '|'));
        $this->assertEmpty($tokenMetaData);
    }

    public function testユーザーIDが存在しなかった場合Exceptionが発生すること(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->userRepo->deleteTokenByUserIdAndToken(
            1234,
            '1234|存在しないトークン'
        );
    }

    public function testトークンが存在しなかった場合Exceptionが発生すること(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->userRepo->deleteTokenByUserIdAndToken(
            $this->user->getUserId(),
            '1234|存在しないトークン'
        );
    }
}
