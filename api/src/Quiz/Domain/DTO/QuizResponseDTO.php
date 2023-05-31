<?php

namespace Eng\Quiz\Domain\DTO;

class QuizResponseDTO
{
    private string $response;
    private bool $isCorrect;
    /** @var QuizResponseReplyDTO[] */
    private array $replyList;

    /**
     * @param string $response
     * @param bool $isCorrect
     * @param QuizResponseReplyDTO[] $replyList
     */
    private function __construct(
        string $response,
        bool $isCorrect,
        array $replyList
    )
    {
        $this->response = $response;
        $this->isCorrect = $isCorrect;
        $this->replyList = $replyList;
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
     * @param string $response
     * @param bool $isCorrect
     * @param QuizResponseReplyDTO[] $replyList
     */
    public static function from(
        string $response,
        bool $isCorrect,
        array $replyList
    ): self
    {
        return new self(
            $response,
            $isCorrect,
            $replyList,
        );
    }
}
