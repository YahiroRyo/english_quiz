<?php

namespace Tests\User\Unit\Repository;

use Eng\User\Infrastructure\Repository\UserRepository;
use Tests\TestCase;

class Base extends TestCase
{
    protected UserRepository $userRepo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepo = new UserRepository();
    }
}
