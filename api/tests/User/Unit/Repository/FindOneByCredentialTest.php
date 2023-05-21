<?php

namespace Tests\User\Unit\Repository;

use Eng\User\Domain\DTO\CredentialDTO;
use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class FindOneByCredentialTest extends Base
{
    private User $user;
    private string $password;
    private ActiveUser $activeUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->password = 'password';
        $this->user = User::create([
            'username' => 'testUsername',
            'password' => Hash::make($this->password),
        ]);
        $this->activeUser = ActiveUser::create([
            'user_id' => $this->user->getUserId(),
            'personality' => 'personality',
            'name' => 'name',
            'icon' => 'icon',
        ]);
    }

    public function testユーザーの取得を行うこと(): void
    {
        $foundUser = $this->userRepo->findOneByCredential(CredentialDTO::from(
            $this->user->getUsername(),
            $this->password,
        ));

        $this->assertEquals($foundUser, UserDTO::from(
            $this->user->getUserId(),
            $this->user->getUsername(),
            $this->user->getPassword(),
            $this->user->getRememberToken(),
            $this->activeUser->getPersonality(),
            $this->activeUser->getName(),
            $this->activeUser->getIcon(),
        ));
    }

    public function testユーザー名が存在しなかった場合Exceptionが発生すること(): void
    {
        $this->expectException(AccessDeniedHttpException::class);

        $this->userRepo->findOneByCredential(CredentialDTO::from(
            '存在しないユーザー名',
            '',
        ));
    }

    public function testパスワードが違った場合Exceptionが発生すること(): void
    {
        $this->expectException(AccessDeniedHttpException::class);

        $this->userRepo->findOneByCredential(CredentialDTO::from(
            $this->user->getUsername(),
            '',
        ));
    }
}
