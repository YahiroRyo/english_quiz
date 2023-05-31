<?php

namespace Tests\Quiz\E2E;

use Eng\Chatgpt\Domain\DTO\ChatMessageDTO;
use Eng\Chatgpt\Domain\Entity\ChatRole;
use Eng\Chatgpt\Infrastructure\Repository\Interface\ChatgptRepository;
use Eng\Quiz\Domain\Entity\QuizEntity;
use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;
use Eng\Quiz\Infrastructure\Repository\DummyQuizCategoryRepository;
use Eng\Quiz\Infrastructure\Repository\DummyQuizRepository;
use Eng\Quiz\Service\Command\CreateQuizService;
use Eng\User\Infrastructure\Repository\UserRepository;
use Mockery;
use Mockery\MockInterface;
use Tests\LoggedInTestCase;

class CreateQuizListTest extends LoggedInTestCase
{
    public function testクイズの作成を行うこと(): void
    {
        /** @var QuizCategory */
        $quizCategory = QuizCategory::first();
        $messageFromChatgpt = [["question" => "現在の時間は何時ですか？", "answer" => "What time is it now?"], ["question" => "あなたは何歳ですか？", "answer" => "How old are you?"]];

        $spyChatgptRepo = $this->spy(ChatgptRepository::class);
        $spyChatgptRepo->shouldReceive('createChat')
            ->andReturn(
                ChatMessageDTO::from(
                    ChatRole::ASSISTANT,
                    json_encode($messageFromChatgpt, JSON_THROW_ON_ERROR)
                )
            );

        $chatgptRepositoryMock = Mockery::mock(
            ChatgptRepository::class,
            function(MockInterface $mock) use ($messageFromChatgpt) {
                $mock->shouldReceive('createChat')
                    ->once()
                    ->andReturn(
                        ChatMessageDTO::from(
                            ChatRole::ASSISTANT,
                            json_encode($messageFromChatgpt, JSON_THROW_ON_ERROR)
                        )
                    );
            },
        );

        $response = $this->post(
            '/api/quiz',
            ['quizCategoryId' => $quizCategory->getQuizCategoryId()],
            ['Authorization' => 'Bearer ' . $this->token ]
        );
        $response->assertOk();

        $createQuizService = new CreateQuizService(
            new DummyQuizRepository(),
            new UserRepository(),
            new DummyQuizCategoryRepository(),
            $chatgptRepositoryMock,
        );
        $quizList = $createQuizService->execute($quizCategory->getQuizCategoryId());

        $this->assertEquals(
            $response->json()['data'],
            array_map(
                function (QuizEntity $quizEntity) {
                    return $quizEntity->toJson();
                },
                $quizList,
            )
        );
    }
}
