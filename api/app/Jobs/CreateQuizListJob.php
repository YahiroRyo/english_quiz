<?php

namespace App\Jobs;

use Aws\Polly\PollyClient;
use Eng\Aws\Infrastructure\Repository\PollyRepository;
use Eng\Chatgpt\Infrastructure\Repository\ChatgptRepository;
use Eng\Quiz\Infrastructure\Eloquent\CreatingQuiz;
use Eng\Quiz\Infrastructure\Repository\CreatableQuizStatusRepository;
use Eng\Quiz\Infrastructure\Repository\QuizCategoryRepository;
use Eng\Quiz\Infrastructure\Repository\QuizRepository;
use Eng\Quiz\Service\Command\CreateQuizService;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class CreateQuizListJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
            new QuizCategoryRepository(),
            new CreatableQuizStatusRepository(),
            new ChatgptRepository(new Client()),
            new PollyRepository(new PollyClient([
                'version' => 'latest',
                'region' => 'ap-northeast-1',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY')
                ]
            ])),
        );

        $createQuizService->execute($this->quizCategoryId, $this->userId);
    }

    public function failed(Throwable $exception)
    {
        CreatingQuiz::where($this->userId)->delete();
    }
}
