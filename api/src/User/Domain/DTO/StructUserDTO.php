<?php

namespace Eng\User\Domain\DTO;

class StructUserDTO
{
    private int $userId;
    private string $username;
    private string $personality;
    private string $name;
    private string $icon;

    public function __construct(
        int $userId,
        string $username,
        string $personality,
        string $name,
        string $icon,
    ) {
        $this->userId = $userId;
        $this->username = $username;
        $this->personality = $personality;
        $this->name = $name;
        $this->icon = $icon;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPersonality(): string
    {
        return $this->personality;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public static function from(
        int $userId,
        string $username,
        string $personality,
        string $name,
        string $icon,
    ): self {
        return new self(
            $userId,
            $username,
            $personality,
            $name,
            $icon,
        );
    }

    public static function fromUserDTO(UserDTO $userDTO): self
    {
        return new self(
            $userDTO->getUserId(),
            $userDTO->getUsername(),
            $userDTO->getPersonality(),
            $userDTO->getName(),
            $userDTO->getIcon(),
        );
    }
}
