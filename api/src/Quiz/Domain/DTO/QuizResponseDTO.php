<?php

namespace Eng\Quiz\Domain\DTO;

class QuizResponseDTO
{
    private int $quizResponseId;
    private string $response;
    private bool $isCorrect;
    /** @var QuizResponseReplyDTO[] */
    private array $replyList;

    /**
     * @param int $quizResponseId
     * @param string $response
     * @param bool $isCorrect
     * @param QuizResponseReplyDTO[] $replyList
     */
    private function __construct(
        int $quizResponseId,
        string $response,
        bool $isCorrect,
        array $replyList
    ) {
        $this->quizResponseId = $quizResponseId;
        $this->response       = $response;
        $this->isCorrect      = $isCorrect;
        $this->replyList      = $replyList;
    }

    public function getQuizResponseId(): string
    {
        return $this->quizResponseId;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getIsCorrect(): bool
    {
        return $this->isCorrect;
    }

    /** @return QuizResponseReplyDTO[] */
    public function getReplyList(): array
    {
        return $this->replyList;
    }

    /**
     * @param int $quizResponseId
     * @param string $response
     * @param bool $isCorrect
     * @param QuizResponseReplyDTO[] $replyList
     */
    public static function from(
        int $quizResponseId,
        string $response,
        bool $isCorrect,
        array $replyList
    ): self {
        return new self(
            $quizResponseId,
            $response,
            $isCorrect,
            $replyList,
        );
    }
}
