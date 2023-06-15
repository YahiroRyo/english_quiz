<?php

namespace Eng\Chatgpt\Domain\DTO;

use Eng\Chatgpt\Domain\Entity\ChatConstants;
use Eng\Chatgpt\Domain\Entity\ChatRole;

class ChatMessageDTO
{
    private ChatRole $role;
    private string $content;
    private string $functionName;

    private function __construct(
        ChatRole $role,
        string $content,
        string $functionName,
    ) {
        $this->role = $role;
        $this->content = $content;
        $this->functionName = $functionName;
    }

    public function getRole(): ChatRole
    {
        return $this->role;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFunctionName(): ?string
    {
        if ($this->functionName === ChatConstants::DEFAULT_FUNCTION_NAME) {
            return null;
        }

        return $this->functionName;
    }

    public function toJson(): array
    {
        if ($this->getFunctionName()) {
            return [
                'role'    => $this->getRole()->toString(),
                'content' => $this->getContent(),
                'name'    => $this->getFunctionName(),
            ];
        }

        return [
            'role'    => $this->getRole()->toString(),
            'content' => $this->getContent(),
        ];
    }

    public static function from(
        ChatRole $role,
        string $content,
        ?string $functionName = null,
    ): self {
        if ($functionName) {
            return new self($role, $content, $functionName);
        }

        return new self($role, $content, ChatConstants::DEFAULT_FUNCTION_NAME);
    }
}
