<?php

namespace Eng\Aws\Domain\Entity;

enum VoiceId: string
{
    case JA_MIZUKI  = 'Mizuki';
    case JA_TAKUMI  = 'Takumi';
    case EN_EMMA    = 'Emma';
    case EN_AMY     = 'Amy';
    case EN_BRIAN   = 'Brian';
    case US_RUTH    = 'Ruth';
    case US_STEPHEN = 'Stephen';

    public function toString()
    {
        return $this->value;
    }
}
