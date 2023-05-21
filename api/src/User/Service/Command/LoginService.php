<?php

namespace Eng\User\Service\Command;

use Eng\User\Domain\DTO\CredentialDTO;
use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;

class LoginService
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function execute(CredentialDTO $loginDTO): UserDTO
    {
        $user = $this->userRepo->findOneByCredential($loginDTO);

        return $this->userRepo->createTokenByUserId($user->getUserId());
    }
}
