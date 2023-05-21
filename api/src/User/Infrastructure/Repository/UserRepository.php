<?php

namespace Eng\User\Infrastructure\Repository;

use Eng\User\Domain\DTO\CredentialDTO;
use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserRepository implements \Eng\User\Infrastructure\Repository\Interface\UserRepository
{
    public function findMe(): UserDTO
    {
        /** @var ?User */
        $user = User::doesntHave('nonActiveUser')
            ->with('activeUser')
            ->find(auth()->id());

        if (!$user) {
            throw new ModelNotFoundException();
        }

        return UserDTO::from(
            $user->getUserId(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getRememberToken(),
            $user->getActiveUser()->getPersonality(),
            $user->getActiveUser()->getName(),
            $user->getActiveUser()->getIcon(),
        );
    }

    public function findOneByCredential(CredentialDTO $credentialDTO): UserDTO
    {
        /** @var ?User */
        $user = User::doesntHave('nonActiveUser')
            ->with('activeUser')
            ->where('username', $credentialDTO->getUsername())
            ->first();

        if (!$user) {
            throw new AccessDeniedHttpException();
        }

        if (!Hash::check($credentialDTO->getPassword(), $user->getPassword())) {
            throw new AccessDeniedHttpException();
        }

        return UserDTO::from(
            $user->getUserId(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getRememberToken(),
            $user->getActiveUser()->getPersonality(),
            $user->getActiveUser()->getName(),
            $user->getActiveUser()->getIcon(),
        );
    }

    public function createUser(UserDTO $userDTO): UserDTO
    {
        /** @var User */
        $user = User::create([
            'username' => $userDTO->getUsername(),
            'password' => $userDTO->getPassword(),
        ]);
        /** @var ActiveUser */
        $activeUser = ActiveUser::create([
            'personality' => $userDTO->getPersonality(),
            'name'        => $userDTO->getName(),
            'icon'        => $userDTO->getIcon(),
        ]);

        return UserDTO::from(
            $user->getUserId(),
            $user->getUsername(),
            $user->getPassword(),
            '',
            $activeUser->getPersonality(),
            $activeUser->getName(),
            $activeUser->getIcon(),
        );
    }

    public function createTokenByUserId(int $userId): UserDTO
    {
        /** @var ?User */
        $user = User::doesntHave('nonActiveUser')
            ->with('activeUser')
            ->where('user_id', $userId)
            ->first();

        if (!$user) {
            throw new ModelNotFoundException();
        }

        $createdToken = $user->createToken(config('app.key'))->plainTextToken;

        return UserDTO::from(
            $user->getUserId(),
            $user->getUsername(),
            $user->getPassword(),
            $createdToken,
            $user->getActiveUser()->getPersonality(),
            $user->getActiveUser()->getName(),
            $user->getActiveUser()->getIcon(),
        );
    }

    public function deleteTokenByUserIdAndToken(int $userId, string $token): UserDTO
    {
        /** @var ?User */
        $user = User::doesntHave('nonActiveUser')
            ->with('activeUser')
            ->find($userId);
        if (!$user) {
            throw new ModelNotFoundException();
        }

        $tokenMetaData = $user->tokens()->find(Str::before($token, '|'));
        if (!$tokenMetaData) {
            throw new ModelNotFoundException();
        }
        $tokenMetaData->delete();

        return UserDTO::from(
            $user->getUserId(),
            $user->getUsername(),
            $user->getPassword(),
            '',
            $user->getActiveUser()->getPersonality(),
            $user->getActiveUser()->getName(),
            $user->getActiveUser()->getIcon(),
        );
    }
}
