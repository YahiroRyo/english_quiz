<?php

namespace Eng\Quiz\Infrastructure\Repository;

use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\Entity\QuizConstants;
use Eng\Quiz\Infrastructure\Eloquent\Quiz;

class QuizRepository implements \Eng\Quiz\Infrastructure\Repository\Interface\QuizRepository
{
    /**
     * @param QuizDTO[] $quizDTOList;
     * @return QuizDTO[]
     */
    public function createQuizList(array $quizDTOList): array
    {
        $result = [];

        foreach ($quizDTOList as $quizDTO) {
            /** @var Quiz */
            $quiz = Quiz::create([
                'user_id'          => $quizDTO->getCreator(),
                'quiz_category_id' => $quizDTO->getQuizCategoryDTO()->getQuizCategoryId(),
                'prompt'           => $quizDTO->getPrompt(),
                'question'         => $quizDTO->getQuestion(),
                'answer'           => $quizDTO->getAnswer(),
            ]);

            array_push(
                $result,
                QuizDTO::from(
                    $quiz->getQuizId(),
                    $quiz->getUserId(),
                    $quiz->getQuestion(),
                    $quiz->getAnswer(),
                    $quiz->getPrompt(),
                    $quizDTO->getQuizCategoryDTO(),
                    QuizResponseDTO::from(
                        QuizConstants::UNRESPONSIVE,
                        false,
                        [],
                    )
                ),
            );
        }

        return $result;
    }
}
