<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class AddMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:2048']
        ];
    }
}
