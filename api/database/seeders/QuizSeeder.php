<?php

namespace Database\Seeders;

use Eng\Quiz\Infrastructure\Eloquent\Quiz;
use Eng\Quiz\Infrastructure\Eloquent\QuizResponse;
use Eng\Quiz\Infrastructure\Eloquent\QuizResponseReply;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class QuizSeeder extends Seeder
{
    private Faker $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $quiz = Quiz::create();
            $response = QuizResponse::create();
            QuizResponseReply::create();
        }
    }
}
