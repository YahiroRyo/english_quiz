<?php

namespace Tests\User\E2E;

use Eng\User\Domain\DTO\CredentialDTO;
use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Eng\User\Infrastructure\Repository\UserRepository;
use Eng\User\Service\Command\LoginService;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
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
    }

    public function testログインを行うこと(): void
    {
        $loginService = new LoginService(new UserRepository());

        $credential = CredentialDTO::from($this->user->getUsername(), $this->password);

        $response     = $this->post('/api/login', $credential->toJson());
        $loggedInUser = $loginService->execute($credential);

        $response->assertOk();

        $responseData     = $response->json()['data'];
        $loggedInUserData = $loggedInUser->toJson();

        $this->assertTrue(strlen($responseData['token']) === 42);
        $this->assertTrue(strlen($loggedInUserData['token']) === 42);

        unset(
            $responseData['token'],
            $loggedInUserData['token']
        );

        $this->assertEquals($responseData, $loggedInUserData);
    }

    public function testログインに失敗した場合403が返ること(): void
    {
        $credential = CredentialDTO::from($this->user->getUsername(), '存在しないパスワード');

        $response = $this->post('/api/login', $credential->toJson());
        $response->assertStatus(403);

        $credential = CredentialDTO::from('存在しないユーザー', $this->password);

        $response = $this->post('/api/login', $credential->toJson());
        $response->assertStatus(403);
    }
}
