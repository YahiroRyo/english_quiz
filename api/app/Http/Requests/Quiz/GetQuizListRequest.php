<?php

namespace App\Http\Requests\Quiz;

use Eng\Quiz\Domain\DTO\GetQuizListDTO;
use Illuminate\Foundation\Http\FormRequest;

class GetQuizListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quizCategoryId'   => ['required', 'integer'],
            'currentPageCount' => ['required', 'integer'],
        ];
    }

    public function toDTO(): GetQuizListDTO
    {
        return GetQuizListDTO::from(
            $this->quizCategoryId,
            $this->currentPageCount,
        );
    }
}
