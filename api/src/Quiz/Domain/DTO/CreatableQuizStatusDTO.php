<?php

namespace Eng\Quiz\Domain\DTO;

enum CreatableQuizStatusDTO: string
{
    case CREATABLE = '作成可能';
    case CREATING  = '作成中';

    public function toString(): string
    {
        return $this->value;
    }
}
