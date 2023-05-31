<?php

namespace Eng\Chatgpt\Domain\Entity;

enum ChatRole: string
{
    case SYSTEM    = 'system';
    case USER      = 'user';
    case ASSISTANT = 'assistant';

    public function toString(): string
    {
        return $this->value;
    }
}
