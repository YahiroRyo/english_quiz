<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class QuizCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'quizCategoryId' => ['required', 'integer']
        ];
    }

    public function all($keys = null)
    {
        return array_merge(
            parent::all(),
            ['quizCategoryId' => $this->route('quizCategoryId')],
        );
    }
}
