<?php

namespace Eng\Chatgpt\Domain\DTO;

use Eng\Chatgpt\Domain\Entity\ChatRole;

class ChatMessageDTO
{
    private ChatRole $role;
    private string $content;

    private function __construct(
        ChatRole $role,
        string $content,
    )
    {
        $this->role = $role;
        $this->content = $content;
    }

    public function getRole(): ChatRole
    {
        return $this->role;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function toJson(): array
    {
        return [
            'role'    => $this->getRole()->toString(),
            'content' => $this->getContent()
        ];
    }

    public static function from(
        ChatRole $role,
        string $content,
    ): self {
        return new self($role, $content);
    }
}
