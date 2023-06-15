<?php

namespace Eng\Chatgpt\Domain\Entity;

enum ChatRole: string
{
    case SYSTEM    = 'system';
    case USER      = 'user';
    case ASSISTANT = 'assistant';
    case FUNCTION  = 'function';

    public function toString(): string
    {
        return $this->value;
    }
}
