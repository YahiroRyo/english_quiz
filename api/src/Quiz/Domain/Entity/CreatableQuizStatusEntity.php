<?php

namespace Eng\Quiz\Domain\Entity;

use Eng\Quiz\Domain\DTO\CreatableQuizStatusDTO;

enum CreatableQuizStatusEntity: string
{
    case CREATABLE = '作成可能';
    case CREATING  = '作成中';

    public function message(): string
    {
        return match($this) {
            self::CREATABLE => 'クイズの作成は可能です。',
            self::CREATING  => 'クイズを作成中のため後ほど作成を行ってください。',
        };
    }

    public function isCreatable(): bool
    {
        return $this === self::CREATABLE;
    }

    public function isCreating(): bool
    {
        return $this === self::CREATING;
    }

    public static function fromDTO(CreatableQuizStatusDTO $creatableQuizStatusDTO): self
    {
        return self::from($creatableQuizStatusDTO->toString());
    }
}
