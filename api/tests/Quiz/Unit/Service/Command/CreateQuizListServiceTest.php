<?php

namespace Tests\Quiz\Unit\Service\Command;

use Eng\Chatgpt\Domain\DTO\ChatMessageDTO;
use Eng\Chatgpt\Domain\Entity\ChatRole;
use Eng\Chatgpt\Infrastructure\Repository\Interface\ChatgptRepository;
use Eng\Quiz\Domain\Entity\QuizEntity;
use Eng\Quiz\Infrastructure\Repository\DummyQuizCategoryRepository;
use Eng\Quiz\Infrastructure\Repository\DummyQuizRepository;
use Eng\Quiz\Service\Command\CreateQuizService;
use Eng\User\Domain\DTO\UserDTO;
use Eng\User\Infrastructure\Repository\Interface\UserRepository;
use JsonException;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateQuizListServiceTest extends TestCase
{
    public function testクイズの作成を行うこと(): void
    {
        $messageFromChatgpt = [["question" => "現在の時間は何時ですか？", "answer" => "What time is it now?"], ["question" => "あなたは何歳ですか？", "answer" => "How old are you?"]];

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

        $userRepositoryMock = Mockery::mock(
            UserRepository::class,
            function(MockInterface $mock) {
                $mock->shouldReceive('findMe')
                    ->once()
                    ->andReturn(UserDTO::from(1, 'test', 'test', '', 'personality', 'name', 'iconURL'));
            }
        );

        $createQuizService = new CreateQuizService(
            new DummyQuizRepository(),
            $userRepositoryMock,
            new DummyQuizCategoryRepository(),
            $chatgptRepositoryMock,
        );

        /** @var QuizEntity[] */
        $quizList = $createQuizService->execute(1);

        $this->assertEquals(
            $messageFromChatgpt,
            array_map(function(QuizEntity $quizEntity) {
                return [
                    "question" => $quizEntity->getQuestion(),
                    "answer" => $quizEntity->getAnswer(),
                ];
            }, $quizList),
        );
    }

    public function testChatgptのレスポンスがjson出なかった場合Exceptionが発生すること(): void
    {
        $chatgptRepositoryMock = Mockery::mock(
            ChatgptRepository::class,
            function(MockInterface $mock) {
                $mock->shouldReceive('createChat')
                    ->once()
                    ->andReturn(
                        ChatMessageDTO::from(
                            ChatRole::ASSISTANT,
                            'にゃーん。(思考停止)'
                        )
                    );
            },
        );

        $userRepositoryMock = Mockery::mock(
            UserRepository::class,
            function(MockInterface $mock) {
                $mock->shouldReceive('findMe')
                    ->once()
                    ->andReturn(UserDTO::from(1, 'test', 'test', '', 'personality', 'name', 'iconURL'));
            }
        );

        $createQuizService = new CreateQuizService(
            new DummyQuizRepository(),
            $userRepositoryMock,
            new DummyQuizCategoryRepository(),
            $chatgptRepositoryMock,
        );

        $this->expectException(JsonException::class);

        /** @var QuizEntity[] */
        $createQuizService->execute(1);
    }
}
