<?php

namespace Tests\User\Unit\Service\Command;

use Eng\Aws\Infrastructure\Repository\DummyS3Repository;
use Eng\User\Domain\DTO\InitUserDTO;
use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;
use Eng\User\Service\Command\RegisterService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;
use Mockery\MockInterface;
use Mockery;
use Tests\TestCase;

class RegisterServiceTest extends TestCase
{
    public function testユーザーの登録を行うこと(): void
    {
        Storage::fake('fake');
        $file = UploadedFile::fake()->image('fake.jpg');

        $initUserDTO = InitUserDTO::from(
            'userregsitertest',
            Hash::make('password'),
            'personality',
            'name',
            InterventionImage::make($file),
        );

        $createdUser = UserDTO::from(
            1,
            $initUserDTO->getUsername(),
            $initUserDTO->getPassword(),
            'token',
            $initUserDTO->getPersonality(),
            $initUserDTO->getName(),
            'iconUrl',
        );

        $mock = Mockery::mock(
            UserRepository::class,
            function (MockInterface $mock) use ($createdUser) {
                $mock->shouldReceive('upsert')
                    ->once()
                    ->andReturn($createdUser);

                $mock->shouldReceive('createTokenByUserId')
                    ->once()
                    ->andReturn($createdUser);
            }
        );

        $registerService = new RegisterService(
            $mock,
            new DummyS3Repository(),
        );
        $registeredUser = $registerService->execute($initUserDTO);

        $this->assertEquals($createdUser, $registeredUser);
    }
}
