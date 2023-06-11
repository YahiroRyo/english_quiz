<?php

namespace Eng\Quiz\Infrastructure\Repository;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;
use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\DTO\QuizResponseReplyDTO;
use Eng\Quiz\Domain\DTO\SearchQuizDTO;
use Eng\Quiz\Domain\DTO\SearchQuizListDTO;
use Eng\Quiz\Domain\DTO\SearchResultQuizListDTO;
use Eng\Quiz\Domain\Entity\QuizConstants;
use Eng\Quiz\Infrastructure\Eloquent\Quiz;
use Eng\Quiz\Infrastructure\Eloquent\QuizResponse;
use Eng\Quiz\Infrastructure\Eloquent\QuizResponseReply;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
            $result[] = QuizDTO::from(
                $quiz->getQuizId(),
                $quiz->getUserId(),
                $quiz->getQuestion(),
                $quiz->getAnswer(),
                $quiz->getPrompt(),
                $quizDTO->getQuizCategoryDTO(),
                QuizResponseDTO::from(
                    QuizConstants::DEFAULT_QUIZ_RESPONSE_ID,
                    QuizConstants::UNRESPONSIVE,
                    false,
                    [],
                )
            );
        }

        return $result;
    }

    public function save(QuizDTO $quizDTO): QuizDTO
    {
        return DB::transaction(function () use ($quizDTO) {
            /** @var Quiz */
            $quiz = Quiz::findOrFail($quizDTO->getQuizId());

            $quiz->update([
                'question' => $quizDTO->getQuestion(),
                'answer'   => $quizDTO->getAnswer(),
                'prompt'   => $quizDTO->getPrompt(),
            ]);
            /** @var ?QuizResponse */
            $quizResponse = QuizResponse::where('quiz_id', $quizDTO->getQuizId())->first();

            if ($quizResponse) {
                $quizResponse->update([
                    'answer'     => $quizDTO->getQuizResponseDTO()->getResponse(),
                    'is_correct' => $quizDTO->getQuizResponseDTO()->getIsCorrect(),
                ]);

                $notSavedQuizResponseReplyDTOList = collect($quizDTO->getQuizResponseDTO()->getReplyList())
                    ->filter(function (QuizResponseReplyDTO $quizResponseReplyDTO) {
                        return $quizResponseReplyDTO->getQuizResponseReplyId() === QuizConstants::DEFAULT_QUIZ_RESPONSE_REPLY_ID;
                    });

                if ($notSavedQuizResponseReplyDTOList->isEmpty()) {
                    return $quizDTO;
                }

                $notSavedQuizResponseReplyDTOList->map(function (QuizResponseReplyDTO $forSaveQuizResponseReplyDTO) {
                    QuizResponseReply::create([
                        'quiz_response_id' => $forSaveQuizResponseReplyDTO->getQuizResponseId(),
                        'role'             => $forSaveQuizResponseReplyDTO->getRole(),
                        'message'          => $forSaveQuizResponseReplyDTO->getMessage(),
                    ]);
                });

                return $quizDTO;
            }

            /** @var QuizResponse */
            $createdQuizResponse = QuizResponse::create([
                'quiz_id'    => $quizDTO->getQuizId(),
                'answer'     => $quizDTO->getQuizResponseDTO()->getResponse(),
                'is_correct' => $quizDTO->getQuizResponseDTO()->getIsCorrect(),
            ]);

            /** @var QuizResponseReplyDTO[] */
            $createdQuizResponseReply = collect($quizDTO->getQuizResponseDTO()->getReplyList())
                ->map(function (QuizResponseReplyDTO $quizResponseReplyDTO) use ($createdQuizResponse) {
                    /** @var QuizResponseReply */
                    $quizResponseReply = QuizResponseReply::create([
                        'quiz_response_id' => $createdQuizResponse->getQuizResponseId(),
                        'role'             => $quizResponseReplyDTO->getRole(),
                        'message'          => $quizResponseReplyDTO->getMessage(),
                    ]);

                    return QuizResponseReplyDTO::from(
                        $quizResponseReply->getQuizResponseReplyId(),
                        $createdQuizResponse->getQuizResponseId(),
                        $quizResponseReply->getRole(),
                        $quizResponseReply->getMessage(),
                        $quizResponseReply->getSendedAt(),
                    );
                })
                ->toArray();

            return QuizDTO::from(
                $quizDTO->getQuizId(),
                $quizDTO->getCreator(),
                $quizDTO->getQuestion(),
                $quizDTO->getAnswer(),
                $quizDTO->getPrompt(),
                $quizDTO->getQuizCategoryDTO(),
                QuizResponseDTO::from(
                    $createdQuizResponse->getQuizResponseId(),
                    $createdQuizResponse->getAnswer(),
                    $createdQuizResponse->getIsCorrect(),
                    $createdQuizResponseReply,
                ),
            );
        }, 3);
    }

    public function findAllBySearchQuizListDTO(SearchQuizListDTO $searchQuizListDTO): SearchResultQuizListDTO
    {
        $quizListCountLimit = 10;
        $quizListCurrentOffset = $quizListCountLimit * ($searchQuizListDTO->getCurrentPageCount() - 1);

        /** @var QuizDTO[] */
        $quizList = Quiz::with(['quizCategory', 'quizResponse.quizResponseReplies'])
            ->where('user_id', $searchQuizListDTO->getUserId())
            ->where('quiz_category_id', $searchQuizListDTO->getQuizCategoryId())
            ->orderBy('created_at', 'desc')
            ->offset($quizListCurrentOffset)
            ->limit($quizListCountLimit)
            ->get()
            ->map(function (Quiz $quiz) {
                if ($quiz->getResponse()) {
                    return QuizDTO::from(
                        $quiz->getQuizId(),
                        $quiz->getUserId(),
                        $quiz->getQuestion(),
                        $quiz->getAnswer(),
                        $quiz->getPrompt(),
                        QuizCategoryDTO::from(
                            $quiz->getQuizCategory()->getQuizCategoryId(),
                            $quiz->getQuizCategory()->getName(),
                            $quiz->getQuizCategory()->getFormalName(),
                        ),
                        QuizResponseDTO::from(
                            $quiz->getResponse()->getQuizResponseId(),
                            $quiz->getResponse()->getAnswer(),
                            $quiz->getResponse()->getIsCorrect(),
                            $quiz->getResponse()
                                ->getQuizResponseReplies()
                                ->map(function (QuizResponseReply $quizResponseReply) {
                                    return QuizResponseReplyDTO::from(
                                        $quizResponseReply->getQuizResponseReplyId(),
                                        $quizResponseReply->getQuizResponseId(),
                                        $quizResponseReply->getRole(),
                                        $quizResponseReply->getMessage(),
                                        $quizResponseReply->getSendedAt(),
                                    );
                                })
                                ->toArray()
                        ),
                    );
                }
                return QuizDTO::from(
                    $quiz->getQuizId(),
                    $quiz->getUserId(),
                    $quiz->getQuestion(),
                    $quiz->getAnswer(),
                    $quiz->getPrompt(),
                    QuizCategoryDTO::from(
                        $quiz->getQuizCategory()->getQuizCategoryId(),
                        $quiz->getQuizCategory()->getName(),
                        $quiz->getQuizCategory()->getFormalName(),
                    ),
                    QuizResponseDTO::from(
                        QuizConstants::DEFAULT_QUIZ_RESPONSE_ID,
                        QuizConstants::UNRESPONSIVE,
                        false,
                        [],
                    ),
                );
            })
            ->toArray();

        $maxQuizListCount = Quiz::with(['quizCategory', 'quizResponse.quizResponseReplies'])
            ->where('user_id', $searchQuizListDTO->getUserId())
            ->where('quiz_category_id', $searchQuizListDTO->getQuizCategoryId())
            ->count();
        $maxPageCount = $maxQuizListCount / $quizListCountLimit;

        return SearchResultQuizListDTO::from(
            $quizList,
            $searchQuizListDTO->getCurrentPageCount(),
            $maxPageCount,
        );
    }

    public function findOneBySearchQuizDTO(SearchQuizDTO $searchQuizDTO): QuizDTO
    {
        /** @var Quiz */
        $quiz = Quiz::with(['quizCategory', 'quizResponse.quizResponseReplies'])
            ->where('user_id', $searchQuizDTO->getUserId())
            ->findOrFail($searchQuizDTO->getQuizId());

        if ($quiz->getResponse()) {
            return QuizDTO::from(
                $quiz->getQuizId(),
                $quiz->getUserId(),
                $quiz->getQuestion(),
                $quiz->getAnswer(),
                $quiz->getPrompt(),
                QuizCategoryDTO::from(
                    $quiz->getQuizCategory()->getQuizCategoryId(),
                    $quiz->getQuizCategory()->getName(),
                    $quiz->getQuizCategory()->getFormalName(),
                ),
                QuizResponseDTO::from(
                    $quiz->getResponse()->getQuizResponseId(),
                    $quiz->getResponse()->getAnswer(),
                    $quiz->getResponse()->getIsCorrect(),
                    $quiz->getResponse()
                        ->getQuizResponseReplies()
                        ->map(function (QuizResponseReply $quizResponseReply) {
                            return QuizResponseReplyDTO::from(
                                $quizResponseReply->getQuizResponseReplyId(),
                                $quizResponseReply->getQuizResponseId(),
                                $quizResponseReply->getRole(),
                                $quizResponseReply->getMessage(),
                                $quizResponseReply->getSendedAt(),
                            );
                        })
                        ->toArray()
                ),
            );
        }

        return QuizDTO::from(
            $quiz->getQuizId(),
            $quiz->getUserId(),
            $quiz->getQuestion(),
            $quiz->getAnswer(),
            $quiz->getPrompt(),
            QuizCategoryDTO::from(
                $quiz->getQuizCategory()->getQuizCategoryId(),
                $quiz->getQuizCategory()->getName(),
                $quiz->getQuizCategory()->getFormalName(),
            ),
            QuizResponseDTO::from(
                QuizConstants::DEFAULT_QUIZ_RESPONSE_ID,
                QuizConstants::UNRESPONSIVE,
                false,
                [],
            ),
        );

    }
}
