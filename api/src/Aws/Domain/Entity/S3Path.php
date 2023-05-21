<?php

namespace Eng\Aws\Domain\Entity;

enum S3Path: string
{
    case USER           = 'image/icons';
    case USER_THUMBNAIL = 'image/icons/thumbnail';

    public function toString()
    {
        return $this->value;
    }
}
