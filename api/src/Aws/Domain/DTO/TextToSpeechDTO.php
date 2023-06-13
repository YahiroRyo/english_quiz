<?php

namespace Eng\Aws\Domain\DTO;

use Eng\Aws\Domain\Entity\VoiceId;

class TextToSpeechDTO
{
    private string $text;
    private VoiceId $voiceId;

    private function __construct(string $text, VoiceId $voiceId)
    {
        $this->text = $text;
        $this->voiceId = $voiceId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getVoiceId(): VoiceId
    {
        return $this->voiceId;
    }

    public static function from(string $text, VoiceId $voiceId): self
    {
        return new self($text, $voiceId);
    }
}
