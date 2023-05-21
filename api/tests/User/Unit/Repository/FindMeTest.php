<?php

namespace Tests\User\Unit\Repository;

use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class FindMeTest extends Base
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

    public function test自分の取得を行う(): void
    {
        $me = $this->userRepo->findMe();

        $this->assertEquals($me->getUserId(), $this->user->getUserId());
    }

    public function test自分が存在しなかった場合Exceptionが発生すること(): void
    {
        auth()->logout();

        $this->expectException(ModelNotFoundException::class);
        $this->userRepo->findMe();
    }
}
