<?php

namespace Tests\User\E2E;

use Eng\Aws\Infrastructure\Repository\DummyS3Repository;
use Eng\User\Domain\DTO\InitUserDTO;
use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Eng\User\Infrastructure\Repository\UserRepository;
use Eng\User\Service\Command\RegisterService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    public function testユーザーを作成すること(): void
    {
        Storage::fake('fake');
        $file = UploadedFile::fake()->image('fake.jpg');

        $initUserDTO = InitUserDTO::from(
            'userregsitertest',
            'password',
            'personality',
            'name',
            InterventionImage::make($file),
        );

        $registerService = new RegisterService(
            new UserRepository(),
            new DummyS3Repository(),
        );

        $registeredUser = $registerService->execute($initUserDTO);
        $registeredUserJson = $registeredUser->toJson();

        $response = $this->post(
            '/api/register',
            [
                'username' => $initUserDTO->getUsername(),
                'password' => $initUserDTO->getPassword(),
                'personality' => $initUserDTO->getPersonality(),
                'name' => $initUserDTO->getName(),
                'icon' => $file,
            ]
        );
        $response->assertOk();
        $responseJson = $response->json()['data'];

        unset(
            $registeredUserJson['token'],
            $registeredUserJson['icon'],
            $registeredUserJson['password'],
            $responseJson['token'],
            $responseJson['icon'],
            $responseJson['password'],
        );

        $this->assertEquals(
            $registeredUserJson,
            $responseJson,
        );
    }
}
