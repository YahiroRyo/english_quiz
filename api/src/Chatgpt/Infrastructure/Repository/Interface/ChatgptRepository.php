<?php

namespace Eng\Chatgpt\Infrastructure\Repository\Interface;

use Eng\Chatgpt\Domain\DTO\ChatMessageDTO;
use Eng\Chatgpt\Domain\DTO\InitChatDTO;

interface ChatgptRepository
{
    public function createChat(InitChatDTO $initChatDTO): ChatMessageDTO;
}
