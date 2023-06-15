<?php

namespace Eng\Quiz\Domain\Entity;

use Eng\Chatgpt\Domain\Entity\ChatRole;
use Eng\Quiz\Domain\DTO\QuizResponseDTO;
use Eng\Quiz\Domain\DTO\QuizResponseReplyDTO;

class QuizResponseEntity
{
    private int $quizResponseId;
    private string $response;
    private bool $isCorrect;
    /** @var QuizResponseReplyEntity[] */
    private array $replyList;

    /**
     * @param int $quizResponseId
     * @param string $response
     * @param bool $isCorrect
     * @param QuizResponseReplyEntity[] $replyList
     */
    private function __construct(
        int $quizResponseId,
        string $response,
        bool $isCorrect,
        array $replyList
    ) {
        $this->quizResponseId = $quizResponseId;
        $this->response = $response;
        $this->isCorrect = $isCorrect;
        $this->replyList = $replyList;
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

    public function getReplyList(): array
    {
        return $this->replyList;
    }

    public function isEmpty(): bool
    {
        return $this->getResponse() === QuizConstants::UNRESPONSIVE;
    }

    public function toJson(): ?array
    {
        if ($this->isEmpty()) {
            return null;
        }

        return [
            'response'  => $this->getResponse(),
            'isCorrect' => $this->getIsCorrect(),
            'replyList' => collect($this->getReplyList())
                ->filter(function (QuizResponseReplyEntity $quizResponseReplyEntity, int $index) {
                    if ($index === 0) {
                        return false;
                    }
                    if ($quizResponseReplyEntity->getRole() === ChatRole::FUNCTION) {
                        return false;
                    }

                    return true;
                })
                ->map(function(QuizResponseReplyEntity $quizResponseReplyEntity) {
                    return $quizResponseReplyEntity->toJson();
                })
                ->values()
                ->toArray(),
        ];
    }

    /**
     * @param int $quizResponseId
     * @param string $response
     * @param bool $isCorrect
     * @param QuizResponseReplyEntity[] $replyList
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

    public static function fromDTO(QuizResponseDTO $quizResponseDTO): self
    {
        return new self(
            $quizResponseDTO->getQuizResponseId(),
            $quizResponseDTO->getResponse(),
            $quizResponseDTO->getIsCorrect(),
            array_map(function (QuizResponseReplyDTO $quizResponseReplyDTO) {
                return QuizResponseReplyEntity::from(
                    ChatRole::from($quizResponseReplyDTO->getRole()),
                    $quizResponseReplyDTO->getQuizResponseReplyId(),
                    $quizResponseReplyDTO->getMessage(),
                    $quizResponseReplyDTO->getFunctionName(),
                    $quizResponseReplyDTO->getSendedAt(),
                );
            }, $quizResponseDTO->getReplyList()),
        );
    }
}
