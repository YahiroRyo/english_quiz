<?php

namespace Eng\Quiz\Infrastructure\Repository\Interface;

use Eng\Quiz\Domain\DTO\CreatableQuizStatusDTO;

interface CreatableQuizStatusRepository
{
    public function findOneByUserId(int $userId): CreatableQuizStatusDTO;

    public function save(int $userId): CreatableQuizStatusDTO;

    public function delete(int $userId): CreatableQuizStatusDTO;
}
