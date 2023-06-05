<?php

namespace Eng\Chatgpt\Infrastructure\Repository;

use Eng\Chatgpt\Domain\DTO\ChatMessageDTO;
use Eng\Chatgpt\Domain\DTO\InitChatDTO;
use Eng\Chatgpt\Domain\Entity\ChatRole;
use GuzzleHttp\ClientInterface;

class ChatgptRepository implements \Eng\Chatgpt\Infrastructure\Repository\Interface\ChatgptRepository
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createChat(InitChatDTO $initChatDTO): ChatMessageDTO
    {
        $messages = array_merge(
            [ChatMessageDTO::from(ChatRole::SYSTEM, $initChatDTO->getPrompt())->toJson()],
            array_map(function (ChatMessageDTO $chatMessageDTO) {
                return $chatMessageDTO->toJson();
            }, $initChatDTO->getMessageList())
        );

        $response = $this->client->request(
            'POST',
            'https://api.openai.com/v1/chat/completions',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . config('chatgpt.token'),
                ],
                'json'    => [
                    'model'       => 'gpt-3.5-turbo',
                    'messages'    => $messages,
                    'temperature' => 0.7,
                    'max_tokens'  => 2048,
                ],
            ]
        );

        $content = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        $responseMessage = $content['choices'][0]['message'];

        logs()->debug($responseMessage);

        return ChatMessageDTO::from(
            ChatRole::from($responseMessage['role']),
            $responseMessage['content'],
        );
    }
}
