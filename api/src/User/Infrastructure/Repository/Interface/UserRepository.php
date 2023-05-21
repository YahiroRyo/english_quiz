<?php

namespace Eng\User\Infrastructure\Repository\Interface;

use Eng\User\Domain\DTO\CredentialDTO;
use Eng\User\Domain\DTO\UserDTO;

interface UserRepository
{
    public function findMe(): UserDTO;

    public function findOneByCredential(CredentialDTO $credentialDTO): UserDTO;

    public function createUser(UserDTO $userDTO): UserDTO;

    public function createTokenByUserId(int $userId): UserDTO;

    public function deleteTokenByUserIdAndToken(int $userId, string $token): UserDTO;
}
