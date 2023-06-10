<?php

namespace Eng\Aws\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Eng\Aws\Domain\DTO\PutImageDTO;
use Eng\Aws\Domain\DTO\S3ImageDTO;
use Eng\Aws\Infrastructure\Repository\Exception\FailUploadFileException;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class S3Repository implements \Eng\Aws\Infrastructure\Repository\Interface\S3Repository
{
    public function putImage(PutImageDTO $putImageDTO): S3ImageDTO
    {
        $now                     = date_format(CarbonImmutable::now(), 'YmdHis');
        $name                    = str_replace(' ', '_', Str::random(24));
        $tmpFileName             = "/tmp/{$now}_{$name}";
        $tmpFileNameForThumbnail = $tmpFileName . '_thumbnail';

        $putImageDTO->getImage()->save($tmpFileNameForThumbnail, $putImageDTO->getQuality(), 'jpg');
        $putImageDTO->getImage()->save($tmpFileName, $putImageDTO->getThumbnailQuality(), 'jpg');

        /** @var \Illuminate\Filesystem\FilesystemAdapter */
        $s3Storage = Storage::disk('s3');

        $thumbnailFilePath          = $s3Storage->putFile(
            $putImageDTO->getImagePath()->toString(),
            new File($tmpFileNameForThumbnail),
            'public'
        );
        if (!$thumbnailFilePath) {
            throw new FailUploadFileException();
        }

        $explodedThumbnailFilePath  = explode('/', $thumbnailFilePath);
        $thumbnailFileName          = $explodedThumbnailFilePath[count($explodedThumbnailFilePath) - 1];

        $imageFilePath = $s3Storage->putFileAs(
            $putImageDTO->getThumbnailPath()->toString(),
            new File($tmpFileName),
            $thumbnailFileName,
            'public'
        );
        if (!$imageFilePath) {
            throw new FailUploadFileException();
        }

        return S3ImageDTO::from(
            config('filesystems.disks.s3.url') . '/' . $imageFilePath,
            config('filesystems.disks.s3.url') . '/' . $thumbnailFilePath,
        );
    }
}
