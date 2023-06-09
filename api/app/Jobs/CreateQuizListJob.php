<?php

namespace App\Jobs;

use Eng\Chatgpt\Infrastructure\Repository\ChatgptRepository;
use Eng\Quiz\Infrastructure\Repository\QuizCategoryRepository;
use Eng\Quiz\Infrastructure\Repository\QuizRepository;
use Eng\Quiz\Service\Command\CreateQuizService;
use Eng\User\Infrastructure\Repository\UserRepository;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateQuizListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $quizCategoryId;
    private int $userId;

    public function __construct(int $quizCategoryId, int $userId)
    {
        $this->quizCategoryId = $quizCategoryId;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $createQuizService = new CreateQuizService(
            new QuizRepository(),
            new UserRepository(),
            new QuizCategoryRepository(),
            new ChatgptRepository(new Client()),
        );
        $createQuizService->execute($this->quizCategoryId, $this->userId);
    }
}
