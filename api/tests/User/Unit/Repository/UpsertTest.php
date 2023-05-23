<?php

namespace Tests\User\Unit\Repository;

use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Domain\Entity\InitUserConstants;
use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Illuminate\Support\Facades\Hash;

class UpsertTest extends Base
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

        $this->actingAs($this->user);
    }

    public function testユーザーの作成を行うこと(): void
    {
        $createdUser = $this->userRepo->upsert(UserDTO::from(
            InitUserConstants::DEFAULT_USER_ID,
            'upserttest',
            Hash::make('password'),
            InitUserConstants::DEFAULT_USER_TOKEN,
            'personality',
            'name',
            'https://placehold.jp/150x150.png'
        ));

        $this->assertNotEmpty(User::find($createdUser->getUserId()));
    }

    public function testユーザーの更新を行うこと(): void
    {
        $createdUser = $this->userRepo->upsert(UserDTO::from(
            InitUserConstants::DEFAULT_USER_ID,
            'upserttest',
            Hash::make('password'),
            InitUserConstants::DEFAULT_USER_TOKEN,
            'personality',
            'name',
            'https://placehold.jp/150x150.png'
        ));

        $this->assertNotEmpty(User::find($createdUser->getUserId()));

        $updatedUser = $this->userRepo->upsert(UserDTO::from(
            $createdUser->getUserId(),
            'upsertUpdate',
            $createdUser->getPassword(),
            $createdUser->getToken(),
            $createdUser->getPersonality(),
            $createdUser->getName(),
            $createdUser->getIcon(),
        ));
        $this->assertNotEquals($createdUser, $updatedUser);
    }
}
