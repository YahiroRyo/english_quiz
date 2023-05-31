<?php

namespace Eng\Quiz\Infrastructure\Repository;

use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\Entity\QuizConstants;

class DummyQuizRepository implements \Eng\Quiz\Infrastructure\Repository\Interface\QuizRepository
{
    /**
     * @param QuizDTO[] $quizDTOList;
     * @return QuizDTO[]
     */
    public function createQuizList(array $quizDTOList): array
    {
        $count = 1;

        return array_map(function(QuizDTO $quizDTO) use (&$count) {
            return QuizDTO::from(
                $count++,
                $quizDTO->getCreator(),
                $quizDTO->getQuestion(),
                $quizDTO->getAnswer(),
                $quizDTO->getPrompt(),
                $quizDTO->getQuizCategoryDTO(),
                QuizResponseDTO::from(
                    QuizConstants::UNRESPONSIVE,
                    false,
                    [],
                )
            );
        }, $quizDTOList);
    }
}
