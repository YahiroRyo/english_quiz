<?php

namespace Database\Seeders;

use Eng\Chatgpt\Domain\Entity\ChatRole;
use Eng\Quiz\Domain\Entity\QuizConstants;
use Eng\Quiz\Infrastructure\Eloquent\Quiz;
use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;
use Eng\Quiz\Infrastructure\Eloquent\QuizResponse;
use Eng\Quiz\Infrastructure\Eloquent\QuizResponseReply;
use Eng\User\Infrastructure\Eloquent\User;
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
        User::all()
            ->map(function (User $user) {
                QuizCategory::all()
                    ->map(function (QuizCategory $quizCategory) use ($user) {
                        for ($i = 0; $i < 3; $i++) {
                            /** @var Quiz */
                            $quiz = Quiz::create([
                                'user_id'          => $user->getUserId(),
                                'quiz_category_id' => $quizCategory->getQuizCategoryId(),
                                'prompt'           => QuizConstants::createQuizPrompt($quizCategory->getFormalName()),
                                'question'         => Str::random(50),
                                'answer'           => Str::random(50),
                            ]);

                            if ($i !== 0) {
                                continue;
                            }

                            /** @var QuizResponse */
                            $quizResponse = QuizResponse::create([
                                'quiz_id'                => $quiz->getQuizId(),
                                'answer'                 => Str::random(50),
                                'is_correct'             => (bool) random_int(0, 1),
                            ]);
                            QuizResponseReply::create([
                                'quiz_response_id' => $quizResponse->getQuizResponseId(),
                                'role'             => ChatRole::ASSISTANT->toString(),
                                'message'          => Str::random(50),
                            ]);
                        }
                    });
            });
    }
}
