<?php

namespace Eng\Aws\Infrastructure\Repository\Interface;

use Eng\Aws\Domain\DTO\TextToSpeechDTO;

interface PollyRepository
{
    public function textToSpeech(TextToSpeechDTO $textToSpeechDTO): string;
}
