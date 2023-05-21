<?php

namespace Tests\User\Unit\Service\Command;

use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;
use Eng\User\Service\Command\LogoutService;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class LogoutServiceTest extends TestCase
{
    public function testログアウトを行うこと(): void
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
                $mock->shouldReceive('findMe')
                    ->once()
                    ->andReturn($userDTO);

                $mock->shouldReceive('deleteTokenByUserIdAndToken')
                    ->once()
                    ->andReturn($userDTO);
            }
        );

        $logoutService = new LogoutService($userRepo);
        $user = $logoutService->execute('token');

        $this->assertEquals($userDTO, $user);
    }
}
