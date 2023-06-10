<?php

namespace Eng\Quiz\Infrastructure\Repository;

use Eng\Quiz\Domain\DTO\CreatableQuizStatusDTO;

class DummyCreatableQuizStatusRepository implements \Eng\Quiz\Infrastructure\Repository\Interface\CreatableQuizStatusRepository
{
    public function findOneByUserId(int $userId): CreatableQuizStatusDTO
    {
        return CreatableQuizStatusDTO::CREATABLE;
    }

    public function save(int $userId): CreatableQuizStatusDTO
    {
        return CreatableQuizStatusDTO::CREATING;
    }

    public function delete(int $userId): CreatableQuizStatusDTO
    {
        return CreatableQuizStatusDTO::CREATABLE;
    }
}
