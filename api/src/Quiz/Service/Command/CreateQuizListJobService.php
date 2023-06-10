<?php

namespace Eng\Quiz\Service\Command;

use App\Jobs\CreateQuizListJob;
use Eng\Quiz\Domain\DTO\CreatableQuizStatusDTO;
use Eng\Quiz\Domain\Entity\CreatableQuizStatusEntity;
use Eng\Quiz\Infrastructure\Repository\Interface\CreatableQuizStatusRepository;
use Eng\Quiz\Service\Exception\AlreadyCreatingQuizException;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;
use Illuminate\Support\Facades\DB;

class CreateQuizListJobService
{
    private UserRepository $userRepo;
    private CreatableQuizStatusRepository $creatableQuizStatusRepo;

    public function __construct(
        UserRepository $userRepo,
        CreatableQuizStatusRepository $creatableQuizStatusRepo
    ) {
        $this->userRepo = $userRepo;
        $this->creatableQuizStatusRepo = $creatableQuizStatusRepo;
    }

    public function execute(int $quizCategoryId): void
    {
        $me = $this->userRepo->findMe();

        $creatableQuizStatusDTO = $this->creatableQuizStatusRepo->findOneByUserId($me->getUserId());
        $creatableQuizStatusEntity = CreatableQuizStatusEntity::fromDTO($creatableQuizStatusDTO);

        if ($creatableQuizStatusEntity->isCreating()) {
            throw new AlreadyCreatingQuizException();
        }

        DB::transaction(function () use ($quizCategoryId, $me) {
            CreateQuizListJob::dispatch(
                $quizCategoryId,
                $me->getUserId(),
            );

            $this->creatableQuizStatusRepo->save($me->getUserId(), CreatableQuizStatusDTO::CREATING);
        });
    }
}
