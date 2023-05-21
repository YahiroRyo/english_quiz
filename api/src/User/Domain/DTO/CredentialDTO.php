<?php

namespace Eng\User\Domain\DTO;

class CredentialDTO
{
    private string $username;
    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function toJson(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }

    public static function from(string $username, string $password): self
    {
        return new self($username, $password);
    }
}
