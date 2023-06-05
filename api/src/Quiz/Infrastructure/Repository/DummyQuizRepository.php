<?php

namespace Eng\Quiz\Infrastructure\Repository;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;
use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\DTO\SearchQuizDTO;
use Eng\Quiz\Domain\DTO\SearchQuizListDTO;
use Eng\Quiz\Domain\DTO\SearchResultQuizListDTO;
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

        return array_map(function (QuizDTO $quizDTO) use (&$count) {
            return QuizDTO::from(
                $count++,
                $quizDTO->getCreator(),
                $quizDTO->getQuestion(),
                $quizDTO->getAnswer(),
                $quizDTO->getPrompt(),
                $quizDTO->getQuizCategoryDTO(),
                QuizResponseDTO::from(
                    QuizConstants::DEFAULT_QUIZ_RESPONSE_ID,
                    QuizConstants::UNRESPONSIVE,
                    false,
                    [],
                )
            );
        }, $quizDTOList);
    }

    public function save(QuizDTO $quizDTO): QuizDTO
    {
        return $quizDTO;
    }

    public function findAllBySearchQuizListDTO(SearchQuizListDTO $searchQuizListDTO): SearchResultQuizListDTO
    {
        return SearchResultQuizListDTO::from(
            [
                QuizDTO::from(
                    1,
                    1,
                    'question',
                    'answer',
                    'prompt',
                    QuizCategoryDTO::from(
                        1,
                        '副詞',
                        '副詞',
                    ),
                    QuizResponseDTO::from(
                        QuizConstants::DEFAULT_QUIZ_RESPONSE_ID,
                        QuizConstants::UNRESPONSIVE,
                        false,
                        [],
                    )
                )
            ],
            $searchQuizListDTO->getCurrentPageCount(),
            $searchQuizListDTO->getCurrentPageCount(),
        );
    }

    public function findOneBySearchQuizDTO(SearchQuizDTO $searchQuizDTO): QuizDTO
    {
        return QuizDTO::from(
            $searchQuizDTO->getQuizId(),
            $searchQuizDTO->getUserId(),
            'question',
            'answer',
            'prompt',
            QuizCategoryDTO::from(
                1,
                '副詞',
                '副詞',
            ),
            QuizResponseDTO::from(
                QuizConstants::DEFAULT_QUIZ_RESPONSE_ID,
                QuizConstants::UNRESPONSIVE,
                false,
                [],
            )
        );
    }
}
