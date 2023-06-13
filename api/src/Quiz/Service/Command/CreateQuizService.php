<?php

namespace Eng\Quiz\Service\Command;

use Eng\Aws\Domain\DTO\TextToSpeechDTO;
use Eng\Aws\Domain\Entity\VoiceId;
use Eng\Aws\Infrastructure\Repository\Interface\PollyRepository;
use Eng\Quiz\Infrastructure\Repository\Interface\QuizRepository;
use Eng\Chatgpt\Infrastructure\Repository\Interface\ChatgptRepository;
use Eng\Quiz\Domain\DTO\QuizDTO;
use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\Entity\QuizConstants;
use Eng\Quiz\Domain\Entity\QuizEntity;
use Eng\Quiz\Infrastructure\Repository\Interface\CreatableQuizStatusRepository;
use Eng\Quiz\Infrastructure\Repository\Interface\QuizCategoryRepository;
use Illuminate\Support\Facades\DB;

class CreateQuizService
{
    private QuizRepository $quizRepo;
    private QuizCategoryRepository $quizCategoryRepo;
    private CreatableQuizStatusRepository $creatableQuizStatusRepo;
    private ChatgptRepository $chatgptRepo;
    private PollyRepository $pollyRepo;

    public function __construct(
        QuizRepository $quizRepo,
        QuizCategoryRepository $quizCategoryRepo,
        CreatableQuizStatusRepository $creatableQuizStatusRepo,
        ChatgptRepository $chatgptRepo,
        PollyRepository $pollyRepo
    ) {
        $this->quizRepo = $quizRepo;
        $this->quizCategoryRepo = $quizCategoryRepo;
        $this->creatableQuizStatusRepo = $creatableQuizStatusRepo;
        $this->chatgptRepo = $chatgptRepo;
        $this->pollyRepo = $pollyRepo;
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
                QuizConstants::BEGIN_JSON_FOR_CREATE_QUIZ_PROMPT . $createdChatMessage->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            $quizList = $this->quizRepo->createQuizList(
                array_map(
                    function (array $quizFromChatMessage) use ($quizCategory, $userId, $prompt) {
                        $speechAnswerUrl = $this->pollyRepo->textToSpeech(TextToSpeechDTO::from(
                            $quizFromChatMessage['answer'],
                            VoiceId::US_STEPHEN,
                        ));

                        return QuizDTO::from(
                            QuizConstants::DEFAULT_QUIZ_ID,
                            $userId,
                            $quizFromChatMessage['question'],
                            $quizFromChatMessage['answer'],
                            $speechAnswerUrl,
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

            $this->creatableQuizStatusRepo->delete($userId);

            return array_map(
                function (QuizDTO $quiz) {
                    return QuizEntity::fromDTO($quiz);
                },
                $quizList
            );
        }, 3);
    }
}
