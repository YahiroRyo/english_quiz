<?php

namespace Eng\User\Service\Command;

use Eng\Aws\Domain\DTO\PutImageDTO;
use Eng\Aws\Domain\Entity\S3Path;
use Eng\Aws\Infrastructure\Repository\Interface\S3Repository;
use Eng\User\Domain\DTO\InitUserDTO;
use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Domain\Entity\InitUserConstants;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    private UserRepository $userRepo;
    private S3Repository $s3Repo;

    public function __construct(
        UserRepository $userRepo,
        S3Repository $s3Repo,
    ) {
        $this->userRepo = $userRepo;
        $this->s3Repo   = $s3Repo;
    }

    public function execute(InitUserDTO $initUserDTO): UserDTO
    {
        return DB::transaction(function() use ($initUserDTO) {
            $s3Image = $this->s3Repo->putImage(PutImageDTO::from(
                $initUserDTO->getIcon(),
                S3Path::USER,
                S3Path::USER_THUMBNAIL,
                80,
                15,
            ));

            $createdUser = $this->userRepo->createUser(UserDTO::from(
                InitUserConstants::DEFAULT_USER_ID,
                $initUserDTO->getUsername(),
                $initUserDTO->getPassword(),
                InitUserConstants::DEFAULT_USER_TOKEN,
                $initUserDTO->getPersonality(),
                $initUserDTO->getName(),
                $s3Image->getImageUrl(),
            ));

            return $this->userRepo->createTokenByUserId($createdUser->getUserId());
        }, 3);
    }
}
