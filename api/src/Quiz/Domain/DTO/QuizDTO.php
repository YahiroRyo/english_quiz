<?php

namespace Eng\Quiz\Domain\DTO;

class QuizDTO
{
    private int $quizId;
    private int $creator;
    private string $question;
    private string $answer;
    private string $prompt;
    private QuizCategoryDTO $quizCategoryDTO;
    private QuizResponseDTO $quizResponseDTO;

    private function __construct(
        int $quizId,
        int $creator,
        string $question,
        string $answer,
        string $prompt,
        QuizCategoryDTO $quizCategoryDTO,
        QuizResponseDTO $quizResponseDTO
    ) {
        $this->quizId = $quizId;
        $this->creator = $creator;
        $this->question = $question;
        $this->answer = $answer;
        $this->prompt = $prompt;
        $this->quizCategoryDTO = $quizCategoryDTO;
        $this->quizResponseDTO = $quizResponseDTO;
    }

    public function getQuizId(): int
    {
        return $this->quizId;
    }

    public function getCreator(): int
    {
        return $this->creator;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getPrompt(): string
    {
        return $this->prompt;
    }

    public function getQuizCategoryDTO(): QuizCategoryDTO
    {
        return $this->quizCategoryDTO;
    }

    public function getQuizResponseDTO(): QuizResponseDTO
    {
        return $this->quizResponseDTO;
    }

    public static function from(
        int $quizId,
        int $creator,
        string $question,
        string $answer,
        string $prompt,
        QuizCategoryDTO $quizCategoryDTO,
        QuizResponseDTO $quizResponseDTO
    ): self {
        return new self(
            $quizId,
            $creator,
            $question,
            $answer,
            $prompt,
            $quizCategoryDTO,
            $quizResponseDTO,
        );
    }
}
