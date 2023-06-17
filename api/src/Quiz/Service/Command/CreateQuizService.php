<?php

namespace Eng\Quiz\Service\Command;

use Eng\Aws\Domain\DTO\TextToSpeechDTO;
use Eng\Aws\Domain\Entity\VoiceId;
use Eng\Aws\Infrastructure\Repository\Interface\PollyRepository;
use Eng\Chatgpt\Domain\DTO\InitChatDTO;
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
    private UserRepository $userRepo;
    private QuizRepository $quizRepo;
    private QuizCategoryRepository $quizCategoryRepo;
    private ChatgptRepository $chatgptRepo;
    private PollyRepository $pollyRepo;

    public function __construct(
        UserRepository $userRepo,
        QuizRepository $quizRepo,
        QuizCategoryRepository $quizCategoryRepo,
        ChatgptRepository $chatgptRepo,
        PollyRepository $pollyRepo
    ) {
        $this->userRepo = $userRepo;
        $this->quizRepo = $quizRepo;
        $this->quizCategoryRepo = $quizCategoryRepo;
        $this->chatgptRepo = $chatgptRepo;
        $this->pollyRepo = $pollyRepo;
    }

    /** @return QuizEntity[] */
    public function execute(int $quizCategoryId): array
    {
        $quizCategory = $this->quizCategoryRepo->findOneByQuizCategoryId($quizCategoryId);

        $prompt = QuizConstants::createQuizPrompt($quizCategory->getFormalName());
        $createdChatMessage = $this->chatgptRepo->createChat(InitChatDTO::from(
            $prompt,
            [],
            []
        ));

        $me = $this->userRepo->findMe();

        return DB::transaction(function () use ($quizCategory, $me, $prompt, $createdChatMessage) {
            /** @var array */
            $quizListFromChatMessage = json_decode(
                $createdChatMessage->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $quizList = $this->quizRepo->createQuizList(
                array_map(
                    function (array $quizFromChatMessage) use ($quizCategory, $me, $prompt) {
                        // $speechAnswerUrl = $this->pollyRepo->textToSpeech(TextToSpeechDTO::from(
                        //     $quizFromChatMessage['answer'],
                        //     VoiceId::US_STEPHEN,
                        // ));

                        return QuizDTO::from(
                            QuizConstants::DEFAULT_QUIZ_ID,
                            $me->getUserId(),
                            $quizFromChatMessage['question'],
                            $quizFromChatMessage['answer'],
                            QuizConstants::DEFAULT_QUIZ_SPEECH_ANSWER_URL,
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
