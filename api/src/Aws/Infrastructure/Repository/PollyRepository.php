<?php

namespace Eng\Aws\Infrastructure\Repository;

use Aws\Polly\PollyClient;
use Eng\Aws\Domain\DTO\TextToSpeechDTO;

class PollyRepository implements \Eng\Aws\Infrastructure\Repository\Interface\PollyRepository
{
    private PollyClient $pollyClient;

    public function __construct(PollyClient $pollyClient)
    {
        $this->pollyClient = $pollyClient;
    }

    public function textToSpeech(TextToSpeechDTO $textToSpeechDTO): string
    {
        $result = $this->pollyClient->startSpeechSynthesisTask([
            'Text'               => $textToSpeechDTO->getText(),
            'Engine'             => 'neural',
            'OutputFormat'       => 'mp3',
            'OutputS3BucketName' => config('filesystems.speech_files.bucket'),
            'VoiceId'            => $textToSpeechDTO->getVoiceId()->toString(),
        ]);

        return config('filesystems.speech_files.url') . '/' . $result['SynthesisTask']['TaskId'] . '.' . $result['SynthesisTask']['OutputFormat'];
    }
}
