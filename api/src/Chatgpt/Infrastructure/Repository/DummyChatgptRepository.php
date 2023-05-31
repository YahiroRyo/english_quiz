<?php

namespace Eng\Chatgpt\Infrastructure\Repository;

use Eng\Chatgpt\Domain\DTO\ChatMessageDTO;
use Eng\Chatgpt\Domain\DTO\InitChatDTO;
use Eng\Chatgpt\Domain\Entity\ChatRole;
use GuzzleHttp\ClientInterface;

class DummyChatgptRepository implements \Eng\Chatgpt\Infrastructure\Repository\Interface\ChatgptRepository
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createChat(InitChatDTO $initChatDTO): ChatMessageDTO
    {
        return ChatMessageDTO::from(
            ChatRole::ASSISTANT,
            '返信です。',
        );
    }
}
