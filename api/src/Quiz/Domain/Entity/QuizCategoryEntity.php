<?php

namespace Eng\Quiz\Domain\Entity;

use Eng\Quiz\Domain\DTO\QuizCategoryDTO;

class QuizCategoryEntity
{
    private int $quizCategoryId;
    private string $name;
    private string $formalName;

    private function __construct(int $quizCategoryId, string $name, string $formalName)
    {
        $this->quizCategoryId = $quizCategoryId;
        $this->name = $name;
        $this->formalName = $formalName;
    }

    public function getQuizCategoryId(): int
    {
        return $this->quizCategoryId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFormalName(): string
    {
        return $this->formalName;
    }

    public function toJson(): array
    {
        return [
            'quizCategoryId' => $this->getQuizCategoryId(),
            'name'           => $this->getName(),
            'formalName'     => $this->getFormalName(),
        ];
    }

    public static function from(int $quizCategoryId, string $name, string $formalName): self
    {
        return new self(
            $quizCategoryId,
            $name,
            $formalName,
        );
    }

    public static function fromDTO(QuizCategoryDTO $quizCategoryDTO): self
    {
        return new self(
            $quizCategoryDTO->getQuizCategoryId(),
            $quizCategoryDTO->getName(),
            $quizCategoryDTO->getFormalName(),
        );
    }
}
