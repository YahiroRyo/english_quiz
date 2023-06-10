<?php

namespace Eng\Quiz\Infrastructure\Repository;

use Eng\Quiz\Domain\DTO\CreatableQuizStatusDTO;
use Eng\Quiz\Infrastructure\Eloquent\CreatingQuiz;

class CreatableQuizStatusRepository implements \Eng\Quiz\Infrastructure\Repository\Interface\CreatableQuizStatusRepository
{
    public function findOneByUserId(int $userId): CreatableQuizStatusDTO
    {
        /** @var ?CreatingQuiz */
        $creatingQuiz = CreatingQuiz::find($userId);

        if ($creatingQuiz) {
            return CreatableQuizStatusDTO::CREATING;
        }
        return CreatableQuizStatusDTO::CREATABLE;
    }

    public function save(int $userId): CreatableQuizStatusDTO
    {
        /** @var ?CreatingQuiz */
        $creatingQuiz = CreatingQuiz::find($userId);

        if ($creatingQuiz) {
            return CreatableQuizStatusDTO::CREATING;
        }

        CreatingQuiz::create([
            'user_id' => $userId,
        ]);
        return CreatableQuizStatusDTO::CREATABLE;
    }

    public function delete(int $userId): CreatableQuizStatusDTO
    {
        CreatingQuiz::find($userId)->delete();

        return CreatableQuizStatusDTO::CREATABLE;
    }
}
