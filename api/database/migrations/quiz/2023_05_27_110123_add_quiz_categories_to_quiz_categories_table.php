<?php

use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    private array $quizCategoryList = [
        [
            'name'        => '副詞',
            'formal_name' => '副詞',
        ],
        [
            'name'        => '疑問詞',
            'formal_name' => '疑問詞',
        ],
        [
            'name'        => '前置詞',
            'formal_name' => '前置詞',
        ],
        [
            'name'        => '等位接続詞',
            'formal_name' => '等位接続詞',
        ],
        [
            'name'        => '助動詞',
            'formal_name' => '助動詞',
        ],
    ];

    private function getQuizCategoryList(): array
    {
        return $this->quizCategoryList;
    }

    public function up(): void
    {
        QuizCategory::insert($this->getQuizCategoryList());
    }

    public function down(): void
    {
        foreach ($this->getQuizCategoryList() as $quizCategory) {
            QuizCategory::where('formal_name', $quizCategory['formal_name'])->delete();
        }
    }
};
