<?php

namespace Eng\User\Service\Command;

use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;

class LogoutService
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function execute(string $bearerToken): UserDTO
    {
        $me = $this->userRepo->findMe();

        return $this->userRepo->deleteTokenByUserIdAndToken(
            $me->getUserId(),
            $bearerToken,
        );
    }
}
