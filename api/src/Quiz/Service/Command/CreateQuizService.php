<?php

namespace Eng\Quiz\Service\Command;

use Eng\Quiz\Infrastructure\Repository\Interface\QuizRepository;
use Eng\Chatgpt\Infrastructure\Repository\Interface\ChatgptRepository;
use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\Entity\QuizConstants;
use Eng\Quiz\Domain\Entity\QuizEntity;
use Eng\Quiz\Infrastructure\Repository\Interface\QuizCategoryRepository;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;
use Illuminate\Support\Facades\DB;

class CreateQuizService
{
    private QuizRepository $quizRepo;
    private UserRepository $userRepo;
    private QuizCategoryRepository $quizCategoryRepo;
    private ChatgptRepository $chatgptRepo;

    public function __construct(
        QuizRepository $quizRepo,
        UserRepository $userRepo,
        QuizCategoryRepository $quizCategoryRepo,
        ChatgptRepository $chatgptRepo
    ) {
        $this->quizRepo = $quizRepo;
        $this->userRepo = $userRepo;
        $this->quizCategoryRepo = $quizCategoryRepo;
        $this->chatgptRepo = $chatgptRepo;
    }

    /** @return QuizEntity[] */
    public function execute(int $quizCategoryId, int $userId): array
    {
        $quizCategory = $this->quizCategoryRepo->findOneByQuizCategoryId($quizCategoryId);

        $prompt = QuizConstants::createQuizPrompt($quizCategory->getFormalName());
        $createdChatMessage = $this->chatgptRepo->createChatOne($prompt);

        return DB::transaction(function () use ($quizCategory, $userId, $prompt, $createdChatMessage) {
            /** @var array */
            $quizListFromChatMessage = json_decode(
                '{ "quizzes": [' . $createdChatMessage->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $quizList = $this->quizRepo->createQuizList(
                array_map(
                    function (array $quizFromChatMessage) use ($quizCategory, $userId, $prompt) {
                        return QuizDTO::from(
                            QuizConstants::DEFAULT_QUIZ_ID,
                            $userId,
                            $quizFromChatMessage['question'],
                            $quizFromChatMessage['answer'],
                            $prompt,
                            $quizCategory,
                            QuizResponseDTO::from(
                                QuizConstants::DEFAULT_QUIZ_RESPONSE_ID,
                                QuizConstants::UNRESPONSIVE,
                                false,
                                [],
                            ),
                        );
                    },
                    $quizListFromChatMessage['quizzes']
                )
            );

            return array_map(
                function (QuizDTO $quiz) {
                    return QuizEntity::fromDTO($quiz);
                },
                $quizList
            );
        }, 3);
    }
}
