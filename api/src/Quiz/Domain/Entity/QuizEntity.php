<?php

namespace Eng\Quiz\Domain\Entity;

use Eng\Quiz\Domain\DTO\QuizDTO;

class QuizEntity
{
    private int $quizId;
    private string $question;
    private string $answer;
    private QuizCategoryEntity $quizCategoryEntity;
    private QuizResponseEntity $quizResponseEntity;

    private function __construct(
        int $quizId,
        string $question,
        string $answer,
        QuizCategoryEntity $quizCategoryEntity,
        QuizResponseEntity $quizResponseEntity
    )
    {
        $this->quizId = $quizId;
        $this->question = $question;
        $this->answer = $answer;
        $this->quizCategoryEntity = $quizCategoryEntity;
        $this->quizResponseEntity = $quizResponseEntity;
    }

    public function getQuizId(): int
    {
        return $this->quizId;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getQuizCategoryEntity(): QuizCategoryEntity
    {
        return $this->quizCategoryEntity;
    }

    public function getQuizResponseEntity(): QuizResponseEntity
    {
        return $this->quizResponseEntity;
    }

    public function toJson(): array
    {
        return [
            'quizId'   => $this->getQuizId(),
            'question' => $this->getQuestion(),
            'answer'   => $this->getAnswer(),
            'category' => $this->getQuizCategoryEntity()->toJson(),
            'response' => $this->getQuizResponseEntity()->toJson(),
        ];
    }

    public static function from(
        int $quizId,
        string $question,
        string $answer,
        QuizCategoryEntity $quizCategoryEntity,
        QuizResponseEntity $quizResponseEntity
    ): self {
        return new self(
            $quizId,
            $question,
            $answer,
            $quizCategoryEntity,
            $quizResponseEntity,
        );
    }

    public static function fromDTO(QuizDTO $quizDTO): self
    {
        return new self(
            $quizDTO->getQuizId(),
            $quizDTO->getQuestion(),
            $quizDTO->getAnswer(),
            QuizCategoryEntity::fromDTO($quizDTO->getQuizCategoryDTO()),
            QuizResponseEntity::fromDTO($quizDTO->getQuizResponseDTO()),
        );
    }
}
