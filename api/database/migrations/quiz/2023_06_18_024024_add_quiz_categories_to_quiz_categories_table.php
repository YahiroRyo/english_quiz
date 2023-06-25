<?php

use Eng\Quiz\Infrastructure\Eloquent\QuizCategory;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    private array $quizCategoryList = [
        [
            'name'        => '間接話法',
            'formal_name' => '間接話法',
        ],
        [
            'name'        => '動名詞',
            'formal_name' => '動名詞',
        ],
        [
            'name'        => 'to不定詞',
            'formal_name' => 'to不定詞',
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
