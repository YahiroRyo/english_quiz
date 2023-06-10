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
        /** @var User */
        $user = User::doesntHave('nonActiveUser')
            ->with('activeUser')
            ->findOrFail(auth()->id());

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

    public function findOneUnsafetyUserByUsername(string $username): ?UserDTO
    {
        /** @var ?User */
        $user = User::doesntHave('nonActiveUser')
            ->with('activeUser')
            ->where('username', $username)
            ->first();

        if (!$user) {
            return null;
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

    public function upsert(UserDTO $userDTO): UserDTO
    {
        /** @var ?User */
        $user = User::doesntHave('nonActiveUser')
            ->with('activeUser')
            ->find($userDTO->getUserId());

        if (!$user) {
            /** @var User */
            $user = User::create([
                'username' => $userDTO->getUsername(),
                'password' => $userDTO->getPassword(),
            ]);
            /** @var ActiveUser */
            $activeUser = ActiveUser::create([
                'user_id'     => $user->getUserId(),
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

        $user->update([
            'username' => $userDTO->getUsername(),
            'password' => $userDTO->getPassword(),
        ]);
        $user->getActiveUser()->update([
            'personality' => $userDTO->getPersonality(),
            'name'        => $userDTO->getName(),
            'icon'        => $userDTO->getIcon(),
        ]);

        return $userDTO;
    }

    public function createTokenByUserId(int $userId): UserDTO
    {
        /** @var User */
        $user = User::doesntHave('nonActiveUser')
            ->with('activeUser')
            ->where('user_id', $userId)
            ->firstOrFail();

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
        /** @var User */
        $user = User::doesntHave('nonActiveUser')
            ->with('activeUser')
            ->findOrFail($userId);

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
