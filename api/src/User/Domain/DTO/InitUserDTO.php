<?php

namespace Eng\User\Domain\DTO;

use Intervention\Image\Image;

class InitUserDTO
{
    private string $username;
    private string $password;
    private string $personality;
    private string $name;
    private Image $icon;

    public function __construct(
        string $username,
        string $password,
        string $personality,
        string $name,
        Image $icon,
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->personality = $personality;
        $this->name = $name;
        $this->icon = $icon;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPersonality(): string
    {
        return $this->personality;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): Image
    {
        return $this->icon;
    }

    public function toJson(): array
    {
        return [
            'username'    => $this->getUsername(),
            'password'    => $this->getPassword(),
            'personality' => $this->getPersonality(),
            'name'        => $this->getName(),
            'icon'        => $this->getIcon(),
        ];
    }

    public static function from(
        string $username,
        string $password,
        string $personality,
        string $name,
        Image $icon,
    ): self {
        return new self(
            $username,
            $password,
            $personality,
            $name,
            $icon,
        );
    }
}
