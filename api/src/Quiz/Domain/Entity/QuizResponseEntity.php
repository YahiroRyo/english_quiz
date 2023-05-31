<?php

namespace Eng\Quiz\Domain\Entity;

use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\DTO\QuizResponseReplyDTO;

class QuizResponseEntity
{
    private string $response;
    private bool $isCorrect;
    /** @var QuizResponseReplyEntity[] */
    private array $replyList;

    /**
     * @param string $response
     * @param bool $isCorrect
     * @param QuizResponseReplyEntity[] $replyList
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

    public function getReplyList(): array
    {
        return $this->replyList;
    }

    private function isEmpty(): bool
    {
        return $this->getResponse() === QuizConstants::UNRESPONSIVE;
    }

    public function toJson(): array
    {
        if ($this->isEmpty()) {
            return [];
        }

        return [
            'response'  => $this->getResponse(),
            'isCorrect' => $this->getIsCorrect(),
            'replyList' => array_map(function(QuizResponseReplyEntity $quizResponseReplyEntity) {
                return $quizResponseReplyEntity->toJson();
            }, $this->getReplyList()),
        ];
    }

    /**
     * @param string $response
     * @param bool $isCorrect
     * @param QuizResponseReplyEntity[] $replyList
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

    public static function fromDTO(QuizResponseDTO $quizResponseDTO): self
    {
        return new self(
            $quizResponseDTO->getResponse(),
            $quizResponseDTO->getIsCorrect(),
            array_map(function(QuizResponseReplyDTO $quizResponseReplyDTO) {
                return QuizResponseReplyEntity::from(
                    $quizResponseReplyDTO->getReplyId(),
                    $quizResponseReplyDTO->getMessage(),
                    $quizResponseReplyDTO->getSendedAt(),
                );
            }, $quizResponseDTO->getReplyList()),
        );
    }
}
