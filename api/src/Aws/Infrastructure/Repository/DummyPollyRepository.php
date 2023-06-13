<?php

namespace Eng\Aws\Infrastructure\Repository;

use Eng\Aws\Domain\DTO\TextToSpeechDTO;

class DummyPollyRepository implements \Eng\Aws\Infrastructure\Repository\Interface\PollyRepository
{
    public function textToSpeech(TextToSpeechDTO $textToSpeechDTO): string
    {
        return '';
    }
}
