<?php

use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    private array $quizCategoryList = [
        [
            'name'        => '形容詞',
            'formal_name' => '形容詞',
        ],
        [
            'name'        => '接続詞',
            'formal_name' => '接続詞',
        ],
        [
            'name'        => '名詞',
            'formal_name' => '名詞',
        ],
        [
            'name'        => '代名詞',
            'formal_name' => '代名詞',
        ],
        [
            'name'        => '間投詞',
            'formal_name' => '間投詞',
        ],
    ];

    private function getQuizCategoryList(): array
    {
        return $this->quizCategoryList;
    }

    public function up(): void
    {
        QuizCategory::where('formal_name', '等位接続詞')->delete();
        QuizCategory::insert($this->getQuizCategoryList());
    }

    public function down(): void
    {
        QuizCategory::insert([
            'name'        => '等位接続詞',
            'formal_name' => '等位接続詞',
        ]);
        foreach ($this->getQuizCategoryList() as $quizCategory) {
            QuizCategory::where('formal_name', $quizCategory['formal_name'])->delete();
        }
    }
};
