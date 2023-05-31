<?php

namespace Eng\Chatgpt\Domain\DTO;

class InitChatDTO
{
    private string $prompt;
    /** @var ChatMessageDTO[] */
    private array $messageList;

    private function __construct(
        string $prompt,
        array $messageList,
    )
    {
        $this->prompt = $prompt;
        $this->messageList = $messageList;
    }

    public function getPrompt(): string
    {
        return $this->prompt;
    }

    /** @return string[] */
    public function getMessageList(): array
    {
        return $this->messageList;
    }

    public static function from(
        string $prompt,
        array $messageList,
    ): self {
        return new self($prompt, $messageList);
    }
}
