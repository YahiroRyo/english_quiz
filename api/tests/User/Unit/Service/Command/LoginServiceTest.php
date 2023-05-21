<?php

namespace Tests\User\Unit\Service\Command;

use Eng\User\Domain\DTO\CredentialDTO;
use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;
use Eng\User\Service\Command\LoginService;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class LoginServiceTest extends TestCase
{
    public function testログインを行うこと(): void
    {
        $password = 'password';

        /** @var User */
        $user = User::create([
            'username' => 'testUsername',
            'password' => Hash::make($password),
        ]);
        /** @var ActiveUser */
        $activeUser = ActiveUser::create([
            'user_id' => $user->getUserId(),
            'personality' => 'personality',
            'name' => 'name',
            'icon' => 'icon',
        ]);

        $userDTO = UserDTO::from(
            $user->getUserId(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getRememberToken(),
            $activeUser->getPersonality(),
            $activeUser->getName(),
            $activeUser->getIcon(),
        );

        $userRepo = Mockery::mock(
            UserRepository::class,
            function (MockInterface $mock) use ($userDTO) {
                $mock->shouldReceive('createTokenByUserId')
                    ->once()
                    ->andReturn($userDTO);

                $mock->shouldReceive('findOneByCredential')
                    ->once()
                    ->andReturn($userDTO);
            }
        );

        $loginService = new LoginService($userRepo);
        $loggedInUser = $loginService->execute(CredentialDTO::from(
            $user->getUsername(),
            $password,
        ));

        $this->assertEquals($userDTO, $loggedInUser);
    }
}
