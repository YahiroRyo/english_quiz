<?php

namespace Eng\Chatgpt\Domain\DTO;

class InitChatDTO
{
    private string $prompt;
    /** @var ChatMessageDTO[] */
    private array $messageList;
    private array $functionList;

    private function __construct(
        string $prompt,
        array $messageList,
        array $functionList,
    ) {
        $this->prompt = $prompt;
        $this->messageList = $messageList;
        $this->functionList = $functionList;
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

    public function getFunctionList(): array
    {
        return $this->functionList;
    }

    public static function from(
        string $prompt,
        array $messageList,
        array $functionList,
    ): self {
        return new self($prompt, $messageList, $functionList);
    }
}
