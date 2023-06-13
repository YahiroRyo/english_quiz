<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositorySettingServiceProvider extends ServiceProvider
{
    private array $repositoryList = [
        \Eng\User\Infrastructure\Repository\Interface\UserRepository::class => \Eng\User\Infrastructure\Repository\UserRepository::class,
        \Eng\Quiz\Infrastructure\Repository\Interface\QuizCategoryRepository::class => \Eng\Quiz\Infrastructure\Repository\QuizCategoryRepository::class,
        \Eng\Quiz\Infrastructure\Repository\Interface\QuizRepository::class => \Eng\Quiz\Infrastructure\Repository\QuizRepository::class,
        \Eng\Quiz\Infrastructure\Repository\Interface\CreatableQuizStatusRepository::class => \Eng\Quiz\Infrastructure\Repository\CreatableQuizStatusRepository::class,
        \Eng\Chatgpt\Infrastructure\Repository\Interface\ChatgptRepository::class => \Eng\Chatgpt\Infrastructure\Repository\ChatgptRepository::class,
        \Eng\Aws\Infrastructure\Repository\Interface\S3Repository::class    => \Eng\Aws\Infrastructure\Repository\S3Repository::class,
        \Eng\Aws\Infrastructure\Repository\Interface\PollyRepository::class    => \Eng\Aws\Infrastructure\Repository\PollyRepository::class,
    ];
    private array $repositoryListForTesting = [
        \Eng\User\Infrastructure\Repository\Interface\UserRepository::class => \Eng\User\Infrastructure\Repository\UserRepository::class,
        \Eng\Quiz\Infrastructure\Repository\Interface\QuizCategoryRepository::class => \Eng\Quiz\Infrastructure\Repository\DummyQuizCategoryRepository::class,
        \Eng\Quiz\Infrastructure\Repository\Interface\QuizRepository::class => \Eng\Quiz\Infrastructure\Repository\DummyQuizRepository::class,
        \Eng\Quiz\Infrastructure\Repository\Interface\CreatableQuizStatusRepository::class => \Eng\Quiz\Infrastructure\Repository\DummyCreatableQuizStatusRepository::class,
        \Eng\Chatgpt\Infrastructure\Repository\Interface\ChatgptRepository::class => \Eng\Chatgpt\Infrastructure\Repository\DummyChatgptRepository::class,
        \Eng\Aws\Infrastructure\Repository\Interface\S3Repository::class    => \Eng\Aws\Infrastructure\Repository\DummyS3Repository::class,
        \Eng\Aws\Infrastructure\Repository\Interface\PollyRepository::class    => \Eng\Aws\Infrastructure\Repository\DummyPollyRepository::class,
    ];

    public function register(): void
    {
        if (config('app.env') === 'testing') {
            foreach ($this->repositoryListForTesting as $impl => $repository) {
                $this->app->bind($impl, $repository);
            }
            return;
        }

        foreach ($this->repositoryList as $impl => $repository) {
            $this->app->bind($impl, $repository);
        }
    }
}
