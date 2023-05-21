<?php

namespace Eng\User\Domain\DTO;

class UserDTO
{
    private int $userId;
    private string $username;
    private string $password;
    private string $token;
    private string $personality;
    private string $name;
    private string $icon;

    public function __construct(
        int $userId,
        string $username,
        string $password,
        string $token,
        string $personality,
        string $name,
        string $icon,
    ) {
        $this->userId = $userId;
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getToken(): string
    {
        return $this->token;
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

    public function toJson(): array
    {
        return [
            'userId'      => $this->getUserId(),
            'username'    => $this->getUsername(),
            'password'    => $this->getPassword(),
            'token'       => $this->getToken(),
            'personality' => $this->getPersonality(),
            'name'        => $this->getName(),
            'icon'        => $this->getIcon(),
        ];
    }

    public static function from(
        int $userId,
        string $username,
        string $password,
        string $token,
        string $personality,
        string $name,
        string $icon,
    ): self {
        return new self(
            $userId,
            $username,
            $password,
            $token,
            $personality,
            $name,
            $icon,
        );
    }
}
