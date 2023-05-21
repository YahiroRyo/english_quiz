<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositorySettingServiceProvider extends ServiceProvider
{
    private array $repositoryList = [
        \Eng\User\Infrastructure\Repository\Interface\UserRepository::class => \Eng\User\Infrastructure\Repository\UserRepository::class,
        \Eng\Aws\Infrastructure\Repository\Interface\S3Repository::class    => \Eng\Aws\Infrastructure\Repository\S3Repository::class,
    ];

    public function register(): void
    {
        foreach ($this->repositoryList as $impl => $repository) {
            $this->app->bind($impl, $repository);
        }
    }
}
