<?php

namespace App\Http\Requests\User;

use Eng\User\Domain\DTO\InitUserDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image as InterventionImage;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username'    => ['required', 'string', 'max:255'],
            'password'    => ['required', 'string', 'max:255'],
            'personality' => ['required', 'string', 'max:512'],
            'name'        => ['required', 'string', 'max:255'],
            'icon'        => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }

    public function toDTO(): InitUserDTO
    {
        $validatedRequest = $this->validated();

        return InitUserDTO::from(
            $validatedRequest['username'],
            Hash::make($validatedRequest['password']),
            $validatedRequest['personality'],
            $validatedRequest['name'],
            InterventionImage::make($this->file('icon'))->fit(480, 480),
        );
    }
}
