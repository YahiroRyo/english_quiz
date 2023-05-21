<?php

namespace Database\Seeders;

use Eng\User\Infrastructure\Eloquent\ActiveUser;
use Eng\User\Infrastructure\Eloquent\NonActiveUser;
use Eng\User\Infrastructure\Eloquent\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    private Faker $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            /** @var User */
            $user = User::create([
                'username' => 'test' . Str::random() . $i,
                'password' => Hash::make('password'),
            ]);

            if ($i % 2 === 0) {
                ActiveUser::create([
                    'user_id'     => $user->getUserId(),
                    'personality' => $this->faker->words(20, true),
                    'name'        => Str::random(),
                    'icon'        => $this->faker->imageUrl(),
                ]);
                continue;
            }

            NonActiveUser::create([
                'user_id'     => $user->getUserId(),
                'personality' => $this->faker->words(20, true),
                'name'        => Str::random(),
                'icon'        => $this->faker->imageUrl(),
            ]);
        }
    }
}
