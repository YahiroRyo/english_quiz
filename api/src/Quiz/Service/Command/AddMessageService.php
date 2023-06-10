<?php

namespace Eng\Quiz\Service\Command;

use Carbon\CarbonImmutable;
use Eng\Chatgpt\Domain\DTO\ChatMessageDTO;
use Eng\Chatgpt\Domain\DTO\InitChatDTO;
use Eng\Chatgpt\Domain\Entity\ChatRole;
use Eng\Quiz\Infrastructure\Repository\Interface\QuizRepository;
use Eng\Chatgpt\Infrastructure\Repository\Interface\ChatgptRepository;
use Eng\Quiz\Domain\DTO\AddMessageToQuizDTO;
use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\DTO\QuizResponseReplyDTO;
use Eng\Quiz\Domain\DTO\SearchQuizDTO;
use Eng\Quiz\Domain\Entity\QuizConstants;
use Eng\Quiz\Domain\Entity\QuizEntity;
use Eng\Quiz\Domain\Entity\QuizResponseReplyEntity;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;

class AddMessageService
{
    private QuizRepository $quizRepo;
    private UserRepository $userRepo;
    private ChatgptRepository $chatgptRepo;

    public function __construct(
        QuizRepository $quizRepo,
        UserRepository $userRepo,
        ChatgptRepository $chatgptRepo
    ) {
        $this->quizRepo = $quizRepo;
        $this->userRepo = $userRepo;
        $this->chatgptRepo = $chatgptRepo;
    }

    public function execute(AddMessageToQuizDTO $addMessageToQuizDTO): QuizEntity
    {
        $me = $this->userRepo->findMe();

        $quizDTO = $this->quizRepo->findOneBySearchQuizDTO(SearchQuizDTO::from(
            $me->getUserId(),
            $addMessageToQuizDTO->getQuizId()
        ));

        $quizEntity = QuizEntity::fromDTO($quizDTO);

        if ($quizEntity->getQuizResponseEntity()->isEmpty()) {
            $responseChatMessage = $this->chatgptRepo->createChat(InitChatDTO::from(
                QuizConstants::quizSolutionInsight(
                    $quizEntity->getQuestion(),
                    $quizEntity->getAnswer(),
                    $addMessageToQuizDTO->getMessage(),
                ),
                []
            ));
            $responseChatMessageJson = json_decode($responseChatMessage->getContent(), true, 512, JSON_THROW_ON_ERROR);

            $createdQuizDTO = $this->quizRepo->save(QuizDTO::from(
                $quizDTO->getQuizId(),
                $quizDTO->getCreator(),
                $quizDTO->getQuestion(),
                $quizDTO->getAnswer(),
                $quizDTO->getPrompt(),
                $quizDTO->getQuizCategoryDTO(),
                QuizResponseDTO::from(
                    QuizConstants::DEFAULT_QUIZ_RESPONSE_ID,
                    $addMessageToQuizDTO->getMessage(),
                    $responseChatMessageJson['is_correct'],
                    [
                        QuizResponseReplyDTO::from(
                            QuizConstants::DEFAULT_QUIZ_RESPONSE_REPLY_ID,
                            QuizConstants::DEFAULT_QUIZ_RESPONSE_ID,
                            $responseChatMessage->getRole()->toString(),
                            $responseChatMessageJson['explanation'],
                            $addMessageToQuizDTO->getSendedAt(),
                        ),
                    ]
                ),
            ));

            return QuizEntity::fromDTO($createdQuizDTO);
        }

        $convertToDTOCommand = function (QuizResponseReplyEntity $quizResponseReplyEntity, int $index) use ($quizEntity) {
            if ($index === 0) {
                return ChatMessageDTO::from(
                    $quizResponseReplyEntity->getRole(),
                    json_encode([
                        'is_correct'  => $quizEntity->getQuizResponseEntity()->getIsCorrect() ? 'true' : 'false',
                        'explanation' => $quizResponseReplyEntity->getMessage(),
                    ], JSON_THROW_ON_ERROR),
                );
            }

            return ChatMessageDTO::from(
                $quizResponseReplyEntity->getRole(),
                $quizResponseReplyEntity->getMessage(),
            );
        };

        $responseChatMessage = $this->chatgptRepo->createChat(InitChatDTO::from(
            QuizConstants::quizSolutionInsight(
                $quizEntity->getQuestion(),
                $quizEntity->getAnswer(),
                $quizEntity->getQuizResponseEntity()->getResponse(),
            ),
            collect($quizEntity->getQuizResponseEntity()->getReplyList())
                ->map($convertToDTOCommand)
                ->merge([
                    ChatMessageDTO::from(
                        ChatRole::USER,
                        $addMessageToQuizDTO->getMessage()
                    )
                ])
                ->toArray(),
        ));

        $updatedQuizDTO = $this->quizRepo->save(QuizDTO::from(
            $quizDTO->getQuizId(),
            $quizDTO->getCreator(),
            $quizDTO->getQuestion(),
            $quizDTO->getAnswer(),
            $quizDTO->getPrompt(),
            $quizDTO->getQuizCategoryDTO(),
            QuizResponseDTO::from(
                $quizDTO->getQuizResponseDTO()->getQuizResponseId(),
                $quizDTO->getQuizResponseDTO()->getResponse(),
                $quizDTO->getQuizResponseDTO()->getIsCorrect(),
                collect($quizDTO->getQuizResponseDTO()->getReplyList())
                    ->merge([
                        QuizResponseReplyDTO::from(
                            QuizConstants::DEFAULT_QUIZ_RESPONSE_REPLY_ID,
                            $quizEntity->getQuizResponseEntity()->getQuizResponseId(),
                            ChatRole::USER->toString(),
                            $addMessageToQuizDTO->getMessage(),
                            $addMessageToQuizDTO->getSendedAt(),
                        ),
                        QuizResponseReplyDTO::from(
                            QuizConstants::DEFAULT_QUIZ_RESPONSE_REPLY_ID,
                            $quizEntity->getQuizResponseEntity()->getQuizResponseId(),
                            $responseChatMessage->getRole()->toString(),
                            $responseChatMessage->getContent(),
                            CarbonImmutable::now(),
                        ),
                    ])
                    ->toArray()
            ),
        ));

        return QuizEntity::fromDTO($updatedQuizDTO);
    }
}
