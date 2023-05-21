<?php

namespace Eng\Aws\Infrastructure\Repository\Interface;

use Eng\Aws\Domain\DTO\PutImageDTO;
use Eng\Aws\Domain\DTO\S3ImageDTO;

interface S3Repository {
    public function putImage(PutImageDTO $putImageDTO): S3ImageDTO;
}
