<?php

namespace App\Http\Requests\User;

use Eng\User\Domain\DTO\CredentialDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ];
    }

    public function toDTO(): CredentialDTO
    {
        $validatedRequest = $this->validated();

        return CredentialDTO::from(
            $validatedRequest['username'],
            $validatedRequest['password'],
        );
    }
}
